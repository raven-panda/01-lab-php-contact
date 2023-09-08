# Lab PHP : Project 1 - Contact

This project involves integrating a web application and implementing the back-end part of a small application for adding contacts.

Create PHP code based on the provided files (*index.html*, *dashboard.html*, *signup.html*).

## Instructions

### Docker

- A database container

- A container Apache + PHP

### Domain Name

- We would access this project using the domain name : **php-dev-1.online**.

### Database organization

- Create an Entity-Relationship Diagram (ERD) using MySQL Workbench for an app that **allows users to register**.

- Implement the database from an **.sql file**.
    - Store their **name**, **firstname**, **email** (which will serve as an identifier) and the **password**.
    - This app will also allow users to **store contacts** with the contact's **name**, **firstname** and **email**.
    - When the user logs in, they should only **see their own contacts**.

### Registration form

- PHP script that allows for the storage of **app users**.

  **/!\ ENCRYPT PASSWORDS /!\\**

### Login form

- PHP script that verifies if the user exists and, if so, redirects the user to the dashboard page.

### Add Contact form

- PHP script that allows **adding a contact to the database**.
    - It should **not allow adding the same contact's email twice** *-> Display 'This email address already exists'*.

- **Associate this contact with the user**, and this new contact should **appear in the list**.