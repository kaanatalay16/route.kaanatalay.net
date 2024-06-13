#!/usr/bin/env python
# coding: utf-8

import numpy as np
import pandas as pd
import math
import matplotlib.pyplot as plt
from scipy.integrate import cumtrapz
from scipy.interpolate import RegularGridInterpolator
import sys

C_r = 0.02 # Şimdilik yuvarlanma katsayısını sabit kabul ettik
M_passenger = 100 # Yolcu kütlesi (kg)
M_load = 50 # Ekstra yük (kg)
M_empty_mass = 2108 # Boş araç kütlesi (kg)
M = M_passenger + M_load + M_empty_mass # Toplam kütle (kg)
G = 9.81 # m/s^2

# sys.argv[1]'den gelen hız verisini kullanarak drive_cycle'ı oluştur
V = np.array([float(i) for i in sys.argv[1].strip('[]').split(',')]) / 3.6 # m/s

t = np.arange(len(V)) # saniye

tan_teta = 0 # Eğim açısının tanjantı
teta = (math.atan(tan_teta) / 100) * (360 / np.pi) # Eğim açısı
A = 2.408 # Aracın rüzgar gören yüzey alanı (m^2)
C_d = 0.24 # Aero sürtünme katsayısı
air_density = 1.2 # Hava yoğunluğu (kg/m^3)
W = 10 # km/h

Efficiency = np.array([[0.1, 0.2, 0.2, 0.2, 0.2, 0.2, 0.2, 0.2, 0.2],
                       [0.2, 0.8, 0.89, 0.92, 0.94, 0.93, 0.93, 0.92, 0.91],
                       [0.2, 0.8, 0.9, 0.93, 0.95, 0.94, 0.93, 0.92, 0.92],
                       [0.2, 0.76, 0.85, 0.91, 0.94, 0.93, 0.9, 0.9, 0.9],
                       [0.2, 0.72, 0.81, 0.86, 0.88, 0.88, 0.88, 0.88, 0.88]])

v_Tork = [0, 10, 200, 400, 600]
v_rpm = [0, 2000, 4000, 6000, 8000, 10000, 12000, 14000, 15000]

acc = np.diff(V) / np.diff(t)
acceleration = np.insert(acc, 0, 0) # m/s^2
distance = cumtrapz(V, t, initial=0) / 1000 # Katedilen mesafe (km)
r = 0.35 # Tekerlek yarıçapı (m)
w = V / r # Açısal hız (rad/s)
w_em = w * 9.73 # Motorun açısal hızı (rad/s)
rpm = w_em * (30 / np.pi) # Motorun RPM değeri

aux_power = 200 # Ek güçler (Watt)
estimated_efficiency = 0.92 # Motor dışında genel zincirleme verim

def force_func(C_r, M, G, teta, V, C_d, A, air_density, W, t, acceleration):
    net_F = np.zeros(len(t))

    for k in range(len(t)):
        if V[k] > 1:
            Tractive_Forces_Tyres = C_r * M * G * np.cos(np.radians(teta))
        else:
            Tractive_Forces_Tyres = 0

        f_air_drag = (1 / 2) * C_d * A * air_density * ((V[k] - (W / 3.6)) ** 2)

        if V[k] > 1:
            y = np.sin(np.radians(teta)) * M * G
        else:
            y = 0

        f_inertia = (M + M * 0.05) * acceleration[k]

        net_F[k] = Tractive_Forces_Tyres + f_air_drag + y + f_inertia

    return net_F

def efficiency_func(v_rpm, v_Tork, Efficiency, rpm, net_F, r, t):
    Efficiency_interp = np.zeros(len(t))
    Tork = np.zeros(len(t))

    interpolating_function = RegularGridInterpolator((v_Tork, v_rpm), Efficiency)

    for b in range(len(t)):
        Tork[b] = (net_F[b] / 9.73) * r
        abs_Tork = abs((net_F[b] / 9.73) * r)
        Efficiency_interp[b] = interpolating_function([abs_Tork, rpm[b]])

    return Efficiency_interp, Tork

net_F = force_func(C_r, M, G, teta, V, C_d, A, air_density, W, t, acceleration)
Motor_Efficiency, Tork = efficiency_func(v_rpm, v_Tork, Efficiency, rpm, net_F, r, t)
Motor_Efficiency = Motor_Efficiency.T

Total_Efficiency = np.zeros(len(Tork))

for i in range(len(t)):
    if Tork[i] >= 0:
        Total_Efficiency[i] = 1 / (Motor_Efficiency[i] * estimated_efficiency)
    else:
        Total_Efficiency[i] = Motor_Efficiency[i] / estimated_efficiency

Total_Efficiency = Total_Efficiency.T

Battery_Power = Total_Efficiency * Tork * w_em + aux_power  # Battery power (Watt)
number_of_cells = 7104  # Number of cells
Cell_Power = Battery_Power / number_of_cells  # Cell power, pil gücü için pil adedine böldük
Total_Cell_Power_Energy_Consumption = np.trapz(Battery_Power, t) / (3600 * 1000)  # Total Energy Consumption (kWh)
Total_Cell_Power_Energy_Consumption_Per_Sec = cumtrapz(Battery_Power, t, initial = 0) / (3600 * 1000)

soc_init = 0.95
soc = np.array([soc_init] + [0] * (len(t) - 1))
voc = np.zeros(len(t))
Cell_Current = np.zeros(len(t))
Battery_Cap = 3.324
Ro = 0.06  # Internal resistance of the cell (Ohm)

print(f'Total Energy Consumption (kWh): {Total_Cell_Power_Energy_Consumption:.3f}')

a = 1.226
b = 0.2797
c = 9.263
Ea = 31500

R = 8.314
T = 273 + 23
P = 0.75
Bir_yil = 96.68
Bes_yil = 88.8
On_yil = 81.35
cycle_num = np.arange(len(Cell_Current))  # Python'da endeksleme 0'dan başlar, bu yüzden bu işlem doğru olacaktır.

for i in range(1, len(t)):
    soc[i] = (1 - soc[i-1]) * 0.71
    voc[i] = (4.166 - 11.19 * soc[i] + 147 * soc[i]**2 - 1047 * soc[i]**3 +
               4219 * soc[i]**4 - 10260 * soc[i]**5 + 15350 * soc[i]**6 -
               13840 * soc[i]**7 + 6897 * soc[i]**8 - 1461 * soc[i]**9) + 0.034
    Cell_Current[i] = (voc[i] - np.sqrt((voc[i]**2) - 4 * Ro * Cell_Power[i])) / (2 * Ro)
    soc[i] = soc[i-1] - (t[i] - t[i-1]) * Cell_Current[i] / (3600 * Battery_Cap)

Cell_Current = np.abs(Cell_Current)
Crate = Cell_Current / Battery_Cap
dod = 1000 * np.abs(np.diff(soc))
dodd = np.insert(dod, 0, 0)

B = np.exp(a * np.exp(-b * Crate) + c)

Q = B * np.exp(-((Ea - (370.3 * Crate)) / (R * T))) * ((dodd * np.arange(len(Cell_Current)) * Battery_Cap) ** P)
B_first = np.exp(a * np.exp(-b * 1) + c)
Q_first = B_first * np.exp(-((Ea - (370.3 * 1)) / (R * T))) * ((dodd[0] * 1 * Battery_Cap) ** P)
Delta_Q = np.zeros(len(Q))
Delta_Q[0] = Q_first
for i in range(1, len(Q)):
    Delta_Q[i] = (Cell_Current[i]/3600) * (P * B[i]**(1/P)) * np.exp(-((Ea - (370.3 * Crate[i])) / (R * T* P ))) * (Q[i]**((P-1)/P))

Delta_Q_sum = np.cumsum(Delta_Q)
Sum_Delta_Q = np.sum(Delta_Q)
Capacity_retention = 100 - Delta_Q_sum

fig, axs = plt.subplots(2, 3, figsize=(15, 10))

# Aging Graph
axs[0, 0].plot(cycle_num, Capacity_retention, linewidth=2)
axs[0, 0].set_title('Aging Graph')
axs[0, 0].set_xlabel('Time (s)')
axs[0, 0].set_ylabel('Capacity Retention (%)')
axs[0, 0].grid(True)
axs[0, 0].ticklabel_format(style='plain', axis='y', useOffset=False)
# axs[0, 0].get_figure().savefig('/home/kaanatalay-route/htdocs/route.kaanatalay.net/storage/app/python/aging_graph.png')

# SoC Graph
axs[0, 1].plot(t, soc, linewidth=2)
axs[0, 1].set_title('SoC Graph')
axs[0, 1].set_xlabel('Time (s)')
axs[0, 1].set_ylabel('%')
axs[0, 1].grid(True)
# axs[0, 1].get_figure().savefig('/home/kaanatalay-route/htdocs/route.kaanatalay.net/storage/app/python/soc_graph.png')

# Battery Power
axs[0, 2].plot(t, Battery_Power, linewidth=2)
axs[0, 2].set_title('Battery Power')
axs[0, 2].set_xlabel('Time (s)')
axs[0, 2].set_ylabel('kw')
axs[0, 2].grid(True)
# axs[0, 2].get_figure().savefig('/home/kaanatalay-route/htdocs/route.kaanatalay.net/storage/app/python/battery_power.png')

# Driving Profile
axs[1, 0].plot(t, V * 3.6, linewidth=2) # Hızı tekrar km/h'ye çevirerek gösteriyoruz
axs[1, 0].set_title('Driving Profile')
axs[1, 0].set_xlabel('Time (s)')
axs[1, 0].set_ylabel('km/h')
axs[1, 0].grid(True)
# axs[1, 0].get_figure().savefig('/home/kaanatalay-route/htdocs/route.kaanatalay.net/storage/app/python/driving_profile.png')

# Total Energy Consumption
axs[1, 1].plot(t, Total_Cell_Power_Energy_Consumption_Per_Sec, linewidth=2)
axs[1, 1].set_title('Total Energy Consumption')
axs[1, 1].set_xlabel('Time (s)')
axs[1, 1].set_ylabel('kWh')
axs[1, 1].grid(True)
# axs[1, 1].get_figure().savefig('/home/kaanatalay-route/htdocs/route.kaanatalay.net/storage/app/python/total_energy_consumption.png')

# Distance
axs[1, 2].plot(t, distance * 1000, linewidth=2)
axs[1, 2].set_title('Distance')
axs[1, 2].set_xlabel('Time (s)')
axs[1, 2].set_ylabel('Covered Distance (m)')
axs[1, 2].grid(True)
axs[1, 2].get_figure().savefig('/home/kaanatalay-route/htdocs/route.kaanatalay.net/storage/app/python/distance.png')

plt.tight_layout()
plt.show()
