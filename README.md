# CSTP1206 Home Salon Webapp Project

## Description

HOME SALON is a service-booking webapp intended to bring personalized styling services to customers. This project is to be completed in 4 iterations.

The following is a list of features to be implemented at project completion:

- [x] Customers can sign up profile accounts
- [x] Customers can sign in profile accounts
- [x] Customers can edit profile accounts
- [x] Customers can browse stylist business profiles
- [x] Customers can create styling service bookings
- [x] Customers can cancel styling service bookings
- [x] Customers can search for stylist business profiles by category
- [x] Customers can give rating to stylist business profiles
- [x] Stylists can sign up business accounts
- [x] Stylists can sign in business accounts
- [x] Stylists can edit business accounts
- [x] Stylists can accept styling service bookings
- [x] Stylists can decline styling service bookings

## Installation

1. Backup and clear out the existing files in `C:\xampp\htdocs` and clone our project code there.

    `git clone https://github.com/pokai-huang0828/cstp1206_home_salon_project.git`

2. Configure your Apache server. Open Xampp and click the "Config" button in front of Apache. Then select "Apache (httpd.conf)". Add the following lines to the file and save the file.

    `#Allow Apache to accept requests from all other domains.`

    `Header set Access-Control-Allow-Origin "*"`

    `Header set Access-Control-Allow-Methods "POST, GET, OPTIONS, DELETE, PUT"`

3. (Re)start the Apache Server.

4. To create the database for our project, open up the system terminal, enter "type sql\homesalon.sql | mysql -u root -p". Then enter your MySQL password. Check for the existence of the project database either via MySQL Workbench or phpmyadmin.

5. Open our webapp by entering `localhost` in your browser.

## Current Project Status

Iteration 4

## Authors

Pokai Haung

Harleen Jhamat

Eric Cheung
