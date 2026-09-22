# DYUni — Virtual Class System

DYUni is a web application for a university. The application holds the records
of the courses, the classes, the lecturers and the students. A lecturer starts
a virtual class. The students join the virtual class, read the class material
and send chat messages.

This document is written in Simplified Technical English.

---

## 1. Description

The application has three types of user. Each type has a different log-in page
and a different menu.

| User type | Log-in page | Function |
|---|---|---|
| Administrator | `adminLogin.php` | Controls the courses, the classes, the lecturers, the students and the other administrators. |
| Lecturer | `lecturerLogin.php` | Reads the assigned class. Starts a virtual class. Sends a file to the students. |
| Student | `login.php` | Reads the courses and the classes. Joins a virtual class. Sends chat messages. |

### 1.1 Functions

**Administrator**

- Adds, changes and deletes a course.
- Adds, changes and deletes a class. Each class has a start time and an end
  time.
- Adds, changes and deletes a lecturer. Assigns the lecturer to a class.
- Adds, changes and deletes a student. Assigns the student to a course.
- Adds another administrator.
- Changes the password of any user.

**Lecturer**

- Reads the assigned class and the assigned course.
- Starts a virtual class. The lecturer sends a file, for example a PDF file.
- Reads the chat messages of the virtual class.
- Reads the list of the students who joined the class.
- Changes the personal data and the password.

**Student**

- Reads the courses and the classes.
- Joins a virtual class that a lecturer started.
- Reads the file that the lecturer sent.
- Sends chat messages to the other participants.
- Changes the personal data and the password.

### 1.2 The virtual class

The virtual class is not a video system. It works in this sequence:

1. The lecturer opens the page of the class. The lecturer selects a file and
   gives the file a name.
2. The application writes the file to the `uploads/` folder. It then writes a
   record to the `virtual_class` table.
3. The application sends the lecturer to the class page. The page shows the
   file in a frame.
4. A student opens the same class. The application writes the student to the
   `participants` table.
5. The student sees the same file.
6. Each participant types a message. The browser sends the message to
   `route/route.php` with jQuery.
7. Each browser asks the server for the messages and for the participant list
   every 8 seconds.

The file `js/virtualClass.js` controls the lecturer page. The file
`js/studentVirtualClass.js` controls the student page.

### 1.3 Technology

| Item | Value |
|---|---|
| Language | PHP 7.x |
| Database | MySQL or MariaDB |
| Database driver | `mysqli` |
| Front end | Bootstrap 4, jQuery |
| Dependencies | None. The project does not use Composer. |

The application does not use a framework. It uses a hand-written
Model-View-Controller structure.

---

## 2. Structure

```
dyutual/
├── index.php             Home page and student log-in
├── login.php             Student log-in page
├── lecturerLogin.php     Lecturer log-in page
├── adminLogin.php        Administrator log-in page
├── register.php          Administrator registration page
├── config.php            Gives the path of the uploads folder
├── .env                  Your credentials. Not in the repository.
├── .env.example          The list of the keys. Copy it to `.env`.
├── route/
│   └── route.php         Front controller. All forms send data to this file.
├── model/
│   ├── db.php            Database connection. All other models extend this class.
│   ├── user.php          Log-in for the three user types. Password change.
│   ├── login.php         Log-in support
│   ├── register.php      Administrator registration
│   ├── Admin.php         Administrator functions
│   ├── adminUsers.php    Administrator account list
│   ├── lecturer.php      Lecturer data and virtual class start
│   ├── students.php      Student data and virtual class entry
│   ├── Courses.php       Course data
│   ├── class.php         Class data
│   ├── virtualClass.php  Virtual class data (not used)
│   └── chat.php          Chat messages and participant list
├── helpers/
│   ├── env.php           Reads the file `.env`
│   ├── sessionHelper.php Session control and access control
│   ├── messages.php      Not used. See section 6.
│   └── report.php        Not used. See section 6.
├── views/
│   ├── index.php         View router. The `page` parameter selects the page.
│   ├── components/       Header, footer, navigation bars and side bar
│   └── pages/            Student pages, `admin/` pages and `lecturer/` pages
├── uploads/              The files of the virtual classes
├── css/  js/  images/    Static files
```

### 2.1 How a request moves through the application

1. The user sends a form to `route/route.php`.
2. `route.php` reads the `$_POST` and `$_GET` keys. It selects one action.
3. `route.php` calls a method of a model class.
4. The model class reads or writes the database.
5. The model class sends the user to a new page with an HTTP redirect.
6. `views/index.php` reads the `page` parameter. It includes the correct page
   file.

`helpers/sessionHelper.php` controls the access. These session keys select the
menu and the pages:

| Session key | Meaning |
|---|---|
| `dyunilog` | The user has logged in. The value is the user name. |
| `admin` | The value `1` shows that the user is an administrator. |
| `lecturer` | The value `1` shows that the user is a lecturer. |
| `user_id` | The identifier of the user in the table of the user type. |
| `virtual_id` | The identifier of the open virtual class. |

---

## 3. Before you start

Get these items:

- PHP 7.x, with the `mysqli` extension
- MySQL 5.7 or MariaDB 10.x
- Apache with `mod_php`, or PHP-FPM with Nginx

**Note:** XAMPP, MAMP or Laragon give you Apache, PHP and MySQL in one
installation. This is the easiest method.

---

## 4. Installation

> **CAUTION:** The application contains fixed links that start with `/dyuni`.
> You must install the application at the URL path `/dyuni`. If you use a
> different path, the redirects fail.

> **CAUTION:** The repository does not contain a database dump. You must make
> the tables manually. Section 4.3 gives the SQL statements.

### 4.1 Put the files in the web root

Copy the project folder into the web root of the server. Give the folder the
name `dyuni`.

| Server | Web root |
|---|---|
| XAMPP (Windows) | `C:\xampp\htdocs\dyuni` |
| XAMPP (macOS) | `/Applications/XAMPP/htdocs/dyuni` |
| MAMP | `/Applications/MAMP/htdocs/dyuni` |
| Linux, Apache | `/var/www/html/dyuni` |

### 4.2 Make the database

Make a database with the name `dyuni`:

```sql
CREATE DATABASE dyuni CHARACTER SET utf8mb4;
```

### 4.3 Make the tables

The schema below comes from the SQL statements in the PHP code. Run the
statements in this sequence.

```sql
USE dyuni;

CREATE TABLE `admin` (
  `AdminID`      INT(11)      NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Fname`        VARCHAR(50)  NOT NULL,
  `Sname`        VARCHAR(50)  NOT NULL,
  `username`     VARCHAR(50)  NOT NULL,
  `password`     VARCHAR(50)  NOT NULL,
  `gender`       VARCHAR(10)  NOT NULL,
  `EmailAddress` VARCHAR(128) NOT NULL
);

CREATE TABLE `course` (
  `CourseID`    INT(11)     NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `CourseTitle` VARCHAR(100) NOT NULL,
  `CourseCode`  VARCHAR(20)  NOT NULL,
  `AdminID`     INT(11)      NOT NULL
);

CREATE TABLE `class` (
  `ClassID`   INT(11)     NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Classname` VARCHAR(100) NOT NULL,
  `CourseID`  INT(11)      NOT NULL,
  `startTime` TIME         NOT NULL,
  `endTime`   TIME         NOT NULL,
  `AdminID`   INT(11)      NOT NULL
);

CREATE TABLE `lecturer` (
  `LecturerID`   INT(11)      NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Fname`        VARCHAR(50)  NOT NULL,
  `Sname`        VARCHAR(50)  NOT NULL,
  `Username`     VARCHAR(50)  NOT NULL,
  `password`     VARCHAR(50)  NOT NULL,
  `Gender`       VARCHAR(10)  NOT NULL,
  `EmailAddress` VARCHAR(128) NOT NULL,
  `ClassID`      INT(11)      NOT NULL,
  `AdminID`      INT(11)      NOT NULL
);

CREATE TABLE `student` (
  `StudentID`    INT(11)      NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Fname`        VARCHAR(50)  NOT NULL,
  `Sname`        VARCHAR(50)  NOT NULL,
  `Username`     VARCHAR(50)  NOT NULL,
  `password`     VARCHAR(50)  NOT NULL,
  `Gender`       VARCHAR(10)  NOT NULL,
  `EmailAddress` VARCHAR(128) NOT NULL,
  `CourseID`     INT(11)      NOT NULL,
  `AdminID`      INT(11)      NOT NULL
);

CREATE TABLE `virtual_class` (
  `virtualClassID` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `ClassID`        INT(11) NOT NULL,
  `files`          VARCHAR(255) NOT NULL
);

CREATE TABLE `chat` (
  `id`             INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `virtualClassID` INT(11) NOT NULL,
  `username`       VARCHAR(50) NOT NULL,
  `message`        TEXT    NOT NULL
);

CREATE TABLE `participants` (
  `id`             INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `virtualClassID` INT(11) NOT NULL,
  `username`       VARCHAR(50) NOT NULL
);
```

The code also reads a table with the name `schedule`. The `schedule` table
joins the class data and the course data. Make it as a view:

```sql
CREATE VIEW `schedule` AS
SELECT
  cl.`ClassID`     AS `ScheduleID`,
  co.`CourseTitle` AS `CourseTitle`,
  co.`CourseCode`  AS `CourseCode`,
  cl.`startTime`   AS `startTime`,
  cl.`endTime`     AS `endTime`
FROM `class` cl
JOIN `course` co ON co.`CourseID` = cl.`CourseID`;
```

**Note:** The schema is inferred from the code. The original dump is lost. Test
each page and add a column if a query fails.

### 4.4 Set the credentials

The application reads the database credentials from a file with the name
`.env`. This file is in the root folder of the project. The file is not in the
repository.

1. Copy the example file:

   ```bash
   cp .env.example .env
   ```

2. Open the file `.env`. Write your own values.

```ini
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=dyuni
DB_USERNAME=root
DB_PASSWORD=
```

> **CAUTION:** Do not add the file `.env` to the repository. The file
> `.gitignore` contains the name `.env`. Keep this line.

**Note:** The file `helpers/env.php` reads the file `.env`. If a key is absent
or empty, the application uses a default value. The defaults are in
`model/db.php`.

### 4.5 Set the permission of the uploads folder

The lecturer sends files to the `uploads/` folder. Give the web server the
permission to write to this folder.

```bash
chmod 775 uploads
```

### 4.6 Make the first administrator account

Open `http://localhost/dyuni/register.php` in a web browser. Complete the form.
This page makes an administrator account, not a student account.

As an alternative, add the account with SQL:

```sql
INSERT INTO `admin` (`Fname`, `Sname`, `username`, `password`, `gender`, `EmailAddress`)
VALUES ('Name', 'Surname', 'admin', MD5('your-password'), 'male', 'admin@example.com');
```

**Note:** The application uses MD5 for all passwords. MD5 is not safe. Read
section 7.

### 4.7 Start the application

Open a web browser. Go to one of these addresses:

| Page | Address |
|---|---|
| Home and student log-in | `http://localhost/dyuni/index.php` |
| Lecturer log-in | `http://localhost/dyuni/lecturerLogin.php` |
| Administrator log-in | `http://localhost/dyuni/adminLogin.php` |

The administrator must add the courses and the classes first. The administrator
then adds the lecturers and the students.

---

## 5. Database

The database has the name `dyuni`. It contains these tables:

| Table | Content |
|---|---|
| `admin` | Administrator accounts |
| `lecturer` | Lecturer accounts. Each lecturer has one class. |
| `student` | Student accounts. Each student has one course. |
| `course` | The courses |
| `class` | The classes. Each class belongs to one course. |
| `schedule` | A view of the class data and the course data |
| `virtual_class` | One record for each virtual class and its file |
| `chat` | The chat messages of each virtual class |
| `participants` | The users who joined each virtual class |

---

## 6. Known problems

These problems are in the code. Read this list before you change the code.

1. **Fixed URL path.** The redirects use the path `/dyuni`. The application
   works at this path only.
2. **No database dump.** Section 4.3 gives an inferred schema. Test each page.
3. **Four page files are absent.** `views/index.php` includes these files, but
   the files are not in the repository:
   - `views/pages/timetable.php`
   - `views/pages/studentPass.php`
   - `views/pages/lecturer/class-materials.php`
   - `views/pages/lecturer/timetable.php`

   The menu links to these pages show an empty page.
4. **The letter case of some file names is incorrect.** `route/route.php`
   includes `../model/Chat.php` and `../model/VirtualClass.php`. The file names
   are `chat.php` and `virtualClass.php`. `views/index.php` includes
   `../model/courses.php`. The file name is `Courses.php`. This code operates
   on Windows and on macOS. It fails on Linux. Correct the names before you put
   the application on a Linux server.
5. **Two helper files are not used.** `helpers/messages.php` and
   `helpers/report.php` are copies from a different project. They include files
   that are not in this project. No code calls them. You can delete them.
6. **`model/virtualClass.php` is not used.** The method `createMessages()` has
   an SQL syntax error and two undefined variables. `model/chat.php` does this
   work.
7. **`register.php` makes an administrator.** The title of the page says
   "register", but the form writes to the `admin` table. Students cannot make
   their own account. An administrator must add each student.
8. **The chat uses a poll.** Each browser asks the server for new messages
   every 8 seconds. Many users make a high load on the server.

---

## 7. Security

> **WARNING:** Do not put this application on a public server. The application
> has serious security defects.

| Defect | Description |
|---|---|
| SQL injection | All queries put variables directly into the SQL text. The code does not use prepared statements. |
| Weak password hash | The code uses MD5 with no salt. |
| ~~Credentials in the code~~ | Corrected. The credentials are now in the file `.env`. |
| No CSRF protection | The forms have no token. |
| No file type control | `uploadFile()` does not test the type of the file. A user can send a PHP file to the `uploads/` folder. |
| Open uploads folder | The web server sends any file in `uploads/` to any visitor. |

To make the application safe, do these tasks:

1. Change all queries to prepared statements.
2. Change MD5 to `password_hash()` and `password_verify()`.
3. ~~Move the database credentials to environment variables.~~ Done. See
   section 4.4.
4. Add a CSRF token to each form.
5. Test the type and the size of each file before you write it to the disk.
6. Stop the execution of PHP in the `uploads/` folder.

---

## 8. Status

This project is complete but it is not maintained. The repository has one
commit: "initialization of dyutual project". The project is an academic work.
