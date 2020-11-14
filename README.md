# CSTP1206 Home Salon Webapp Project 

## Description

HOME SALON is a service-booking webapp intended to bring personalized styling services to customers. This project is to be completed in 4 iterations. 

The following is a list of features to be implemented at project completion:

- [x] Customers can browse business profiles
- [ ] Customers can book for styling services
- [x] Customers can search for stylists by category
- [ ] Customers can review business service
- [x] Stylists can edit their business profiles
- [ ] Stylists can manage service bookings
- [ ] Both Customers and Stylists can file reports to Web-Admin

## Installation

1. Git clone the Home Salon Webapp Project:

    `git clone https://github.com/pokai-huang0828/cstp1206_home_salon_project.git`

2. Backup and clear out the current files in C:\xampp\htdocs and add the project code to the folder.

3. To configure Apache server, open Xampp and click "Config" button in front of Apache. Then select "Apache (httpd.conf)". Add the following lines to the file and save the file. 

- #Allow Apache to accept requests from all other domains.

- Header set Access-Control-Allow-Origin "*"

- Header set Access-Control-Allow-Methods "POST, GET, OPTIONS, DELETE, PUT"

4. Start Apache

5. Open the cloned project using VScode.

6. Download a Live Server Extension in VScode.

7. Serve index.html in the root directory with the live server. 

## Current Project Status

Iteration 2

## Authors

Pokai Haung

Harleen Jhamat

Eric Cheung
