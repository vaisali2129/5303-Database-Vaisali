
### Title: Commuter Airline Test Queries
### Team: Vaisali Namburi,Ramesh Mannava,Naveen Vupputuri


#### Question 1:
Show all passengers

SQL:
'''
SELECT * 
FROM  `Users` 
WHERE  ` Role_Id` = ( 
SELECT Role_Id
FROM Role
WHERE User_Type =  'Passenger' ) 
'''

#### Answer:
'''
5660ae2cf2af6
alonso
consuelo
7301 avenida de burgos
mÃ¡laga
castilla la manc
46636
consuelo.alonso@example.com
jeremy1
996-668-333
3333
81

5660ae2b7f659
velasco
mariano
3440 calle mota
santiago de comp
cantabria
93890
mariano.velasco@example.com
badgirl
911-763-962
3333
30

'''



#### Question 2:
Show all administrators that have access

SQL:
'''
SELECT * 
FROM  `Users` 
WHERE  ` Role_Id` = ( 
SELECT Role_Id
FROM Role
WHERE User_Type =  'Admin' ) 
LIMIT 0 , 30
'''

#### Answer:
'''
5660ae2c15143
aguilar
carlos
6683 calle de Ãngel garcÃ­a
murcia
islas baleares
54868
carlos.aguilar@example.com
california
962-753-673
1111
50

5660ae2c327ed
blanco
encarnacion
5521 paseo de zorrilla
cÃ³rdoba
la rioja
46774
encarnacion.blanco@example.com
dorian
934-746-967
1111
54

5660ae2b17901
blanco
iker
5524 calle de la almudena
pamplona
cantabria
21329
iker.blanco@example.com
milfnew
998-719-680
1111
15
'''



#### Question 3:
Show all reservations organized by Flight Number.

SQL:
'''
SELECT * 
FROM  `Reservations` 
ORDER BY Flight_Number
LIMIT 0 , 30
'''

#### Answer:
'''
566242feb00a3
700-DL
2015-12-04 17:48:24
1
9999
5660ae2b29357
BS22

566242ff1e8cf
700-DL
2015-12-04 17:48:24
7
7777
5660ae2d22cbc
BS22

566242ff54b59
701-DL
2015-12-22 16:11:53
8
9999
5660ae2c84576
FR11
'''



#### Question 4:
Show the tail number and status of all aircraft

SQL:
'''
SELECT Tail_Number, 
STATUS FROM  `Aircraft` 
LIMIT 0 , 30
'''

#### Answer:
'''
Tail_Number
STATUS

131EV
1

132EV
0

133EV
1
'''



#### Question 5:
Show a history of reservations for passenger x

SQL:
'''
SELECT * 
FROM  `Reservations` 
WHERE UUID = ( 
SELECT UUID
FROM Users
WHERE Last_Name =  'arias'
AND First_Name =  'carla' ) 
LIMIT 0 , 30
'''

#### Answer:
'''
Reservations_Id
Flight_Number
Flight_Date
Seat_Number
Meal_Id
UUID
Class_Id

566242ff24715
715-STH
2015-12-04 17:48:41
2
8888
5660ae2ac8855
CO33
'''



#### Question 6:
Add a new customer(passenger)

SQL:
'''
INSERT INTO Users
VALUES (
 '56636407986dc',  'Naveen Sai',  'Vupputuri',  '4700 Taft Blvd',  'Wichita falls',  'Texas',  '76308',  'naveensai.vupputuri1@gmail.com',  'nvupputuri', '940-324-9856', (

SELECT Role_Id
FROM Role
WHERE User_Type =  'Passenger'
), 99
)
'''

#### Answer:
'''
1 row effected.
'''



#### Question 7:
Add a new administrator(worker)

SQL:
'''
INSERT INTO Users
VALUES (
 '566361962b40e',  'Mannava',  'Ramesh',  '4700 Taft Blvd',  'Wichita falls',  'Texas',  '76308',  'rmannava94@gmail.com',  'rmannava',  '940-782-6476', (

SELECT Role_Id
FROM Role
WHERE User_Type =  'Admin'
), 7
)
'''

#### Answer:

'''
1 row affected.
'''


#### Question 8:
Determine if a specific flight is full

SQL:
'''
select x.Tail
from 
(SELECT COUNT( * ) PassCount , f.Tail_Number as Tail
FROM Reservations rs, Flights f
WHERE  rs.`Flight_Number` = f.`Flight_Number` 
AND rs.`Flight_Date` = f.`Flight_Date`
and rs.`Flight_Number` ='700-DL'
and rs.`Flight_Date` = '2015-12-04 17:48:24') as x, Aircraft a
where a.capacity<PassCount and a.`Tail_Number` = x.Tail
'''

#### Answer:
'''
Flights are not full.
'''



#### Question 9:
Find all flights that are delayed.

SQL:
'''
SELECT * 
FROM  `Flights` 
WHERE  `Status` =  'Delayed'
LIMIT 0 , 30
'''

#### Answer:
'''
Flight_Number
Flight_Date
Tail_Number
Status
Departure_Time
Distance_Id Ascending
Arrival_Time

701-DL
2015-12-22 16:11:53
131EV
Delayed
16:11:53
301
19:11:53

703-DL
2015-07-22 12:12:24
133EV
Delayed
12:12:24
303
17:12:24

707-DL
2015-01-02 16:19:36
138EV
Delayed
16:19:36
307
22:19:36
'''



#### Question 10:
Cancel a Reservation.

SQL:
'''
DELETE 
FROM Reservations 
WHERE Reservations_Id =  '566242ff28ec3'

'''

#### Answer:
'''
1 row deleted.

'''



#### Question 11:
Show a history of flights that each aircraft was assigned to.

SQL:
'''
SELECT * 
FROM  `Flights` 
WHERE Tail_Number
IN (

SELECT DISTINCT (
Tail_Number
)
FROM Aircraft
)
LIMIT 0 , 30

'''

#### Answer:
'''
Flight_Number
Flight_Date
Tail_Number
Status
Departure_Time
Distance_Id Ascending
Arrival_Time

700-DL
2015-12-04 17:48:24
605LR
On-Time
14:49:58
300
16:49:58

701-DL
2015-12-22 16:11:53
131EV
Delayed
16:11:53
301
19:11:53

702-DL
2015-02-21 22:18:41
132EV
Cancelled
22:18:41
302
23:18:41
'''



#### Question 12:
Add a new user

SQL:
'''
INSERT INTO Users
VALUES (
 '56636393029e1',  'Vaisali',  'Namburi',  '4700 Taft Blvd',  'Wichita falls',  'Texas',  '76308',  'vnamburi93@gmail.com',  'vnamburi',  '940-987-6496', (

SELECT Role_Id
FROM Role
WHERE User_Type =  'Staff'
), 67
)
'''

#### Answer:
'''
1 row affected.
'''



#### Question 13:
List all flights in which a passenger requested a vegetarian meal

SQL:
'''
SELECT * 
FROM  `Flights` 
WHERE Flight_Number
IN (

SELECT Flight_Number
FROM Reservations
WHERE Meal_Id = ( 
SELECT Meal_Id
FROM Meals
WHERE Meal_Type =  'Vegetarian' )
)
LIMIT 0 , 30
'''

#### Answer:
'''
Flight_Number
Flight_Date
Tail_Number
Status
Departure_Time
Distance_Id Ascending
Arrival_Time

700-DL
2015-12-04 17:48:24
605LR
On-Time
14:49:58
300
16:49:58

703-DL
2015-07-22 12:12:24
133EV
Delayed
12:12:24
303
17:12:24

706-DL
2015-12-04 17:49:03
137EV
On-Time
22:06:05
306
23:06:05
'''



#### Question 14:
Show a list of all current flights,their status,and how full(via a percentage) they are.

SQL:
'''

'''

#### Answer:
'''

'''



#### Question 15:
Show all flights leaving x and going to y(where x and y are cities or airports).

SQL:
'''
SELECT * 
FROM  `Flights` 
WHERE Distance_Id
IN (

SELECT Distance_Id
FROM Distance d
WHERE d.From =  'LAX'
AND d.To =  'DFW'
)
LIMIT 0 , 30
'''

#### Answer:
'''
Flight_Number
Flight_Date
Tail_Number
Status
Departure_Time
Distance_Id
Arrival_Time

704-DL
2015-01-10 11:14:01
135EV
Cancelled
11:14:01
304
00:14:01
'''



#### Question 16:
Show all flights leaving x and going to y on date z

SQL:
'''
SELECT * 
FROM  `Flights` 
WHERE Distance_Id
IN (

SELECT Distance_Id
FROM Distance d
WHERE d.From =  'LAX'
AND d.To =  'DFW'
)
AND Flight_Date =  '2015-01-10 11:14:01'
LIMIT 0 , 30
'''

#### Answer:
'''
Flight_Number
Flight_Date
Tail_Number
Status
Departure_Time
Distance_Id
Arrival_Time

704-DL
2015-01-10 11:14:01
135EV
Cancelled
11:14:01
304
00:14:01
'''



#### Question 17:
Show all flights leaving x and going to y on date z where departure time is in between T1 and T2

SQL:
'''
SELECT * 
FROM  `Flights` 
WHERE Distance_Id
IN (

SELECT Distance_Id
FROM Distance d
WHERE d.From =  'LAX'
AND d.To =  'DFW'
)
AND Departure_Time
BETWEEN  '05:53:49'
AND  '22:34:51'
LIMIT 0 , 30
'''


#### Answer:
'''
Flight_Number
Flight_Date
Tail_Number
Status
Departure_Time
Distance_Id
Arrival_Time

704-DL
2015-01-10 11:14:01
135EV
Cancelled
11:14:01
304
00:14:01

'''



#### Question 18:
List all planes according to capacity

SQL:
'''
SELECT * 
FROM  `Aircraft` 
ORDER BY Capacity
LIMIT 0 , 30
'''

#### Answer:
'''
Tail_Number
Airline
Manufacture
Model
Capacity Ascending
Status
First_Class_Seats
Business_Class_Seats
Coach_Class_Seats
Window_Seats
Isle_Seats

61940
SOUTHWEST AIRLIN
CESSNA
172M
4
1
1
1
2
4
0

8791Q
SOUTHWEST AIRLIN
CESSNA
TU206G
6
0
1
2
3
4
2

4460C
CONTINENTAL AIRL
CAMERON BALLOONS
N-105
6
0
1
2
3
4
2

8878
DELTA AIR LINES
CURTISS WRIGHT
TRAVEL AIR 6-B
6
1
1
2
3
4
2

915XJ
DELTA AIR LINES
BOMBARDIER INC
CL600-2D24
22
0
5
7
10
14
8
'''



#### Question 19:
Show remaining number of Isle/Window seats available on a specific flight.

SQL:
'''
SELECT (
(
SELECT  `Window_Seats` 
FROM  `Aircraft` 
WHERE  `Tail_Number` = ( 
SELECT Tail_Number
FROM Flights
WHERE Flight_Number =  '700-DL'
AND Flight_Date =  '2015-12-04 17:48:24' )
) - ( 
SELECT COUNT( * ) 
FROM Reservations
WHERE Seat_Number %2 =0
AND Flight_Number =  '700-DL'
AND Flight_Date =  '2015-12-04 17:48:24' )
) as remaining
FROM dual
LIMIT 0 , 30
'''

#### Answer:
'''
remaining
14
'''



#### Question 20:
Select the number of available first class/business/coach seats available for agiven flight.

SQL:
'''
SELECT (
(

SELECT  `Business_Class_Seats` 
FROM  `Aircraft` 
WHERE  `Tail_Number` = ( 
SELECT Tail_Number
FROM Flights
WHERE Flight_Number =  '700-DL'
AND Flight_Date =  '2015-12-04 17:48:24' )
) - ( 
SELECT COUNT( * ) 
FROM Reservations
WHERE Class_Id =  'BS22'
AND Flight_Number =  '700-DL'
AND Flight_Date =  '2015-12-04 17:48:24' )
) AS remaining
FROM dual
LIMIT 0 , 30
'''

#### Answer:
'''
remaining
5
'''



#### Question 21:
Alter a reservation

SQL:
'''
UPDATE Reservations SET Meal_Id =8888 WHERE Reservations_Id =  '566242fea9007'
'''

#### Answer:
'''
1 row affected
'''



#### Question 22:
Determine the fare of a flight(Fare = $50 +(Distance * $0.11))

SQL:
'''
SELECT ( 50 + ( 
SELECT Distance
FROM  `Distance` 
WHERE Distance_Id = ( 
SELECT Distance_Id
FROM Flights
WHERE Flight_Number =  '707-DL' ) ) * 0.11 ) AS Fare
FROM dual
LIMIT 0 , 30
'''

#### Answer:
'''
Fare
268.9
'''

