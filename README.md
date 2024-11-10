# Barangay Online Document Request System

## Project Objectives
The primary objective of this project is to develop an online document request system for barangay residents, with the following goals:

- **Efficiency**: Streamline the document request process for both barangay staff and residents, reducing processing time.
- **Accessibility**: Allow residents to view and request documents online from any location with an internet connection.
- **Transparency**: Provide real-time updates on the status of requested documents.
- **Data Integrity**: Ensure secure data management, minimizing the risk of errors and data loss.

## User Interface Design

### User Login
- Users enter their username and password to access the system, with an eye icon available to verify their password input.
- The system checks the login details and only grants access to verified users. New users can click "Sign Up Here" to register.

### User Signup
- Users fill out a form with required details (e.g., name, email, username, password, ID attachment, photo, emergency contact).
- Once validated, a new account is created, allowing users access to the platform.

### User Information
- After logging in, users are directed to their dashboard to view or edit their personal information.

### User Menu
- The menu provides access to options like "My Profile," "Document Requests," "History," "Settings," and "Logout."

### User Request Document
- Users can submit a request for specific documents and specify their purpose, ensuring accurate identification of requests.

### User History
- Displays a record of previous requests with timestamps, scheduled release dates, current statuses, and options to manage entries.

### User Settings
- Provides options for updating personal details, attachments, password, or assigning a contact person. Users can also delete their account if needed.

## Admin Interface Design

### Admin Login
- Admins enter their credentials to access the system, with verification ensuring only authorized access.

### Masterlist Page
- Displays user profiles with options to contact, view emergency contact info, or delete users. Provides easy navigation and email integration.

### Menu Bar
- Accessible from the top-left corner, with options for "Masterlist," "Document Requests," "Document Generator," "ID Generator," "Admin Credentials," and "Log Out."

### Document Request
- Organizes requests into tables for pending, approved, completed, and denied requests, with options to manage each request's status and generate documents.

### Document Generator
- Admins can generate official documents by inputting user details and selecting document type. Generated documents are available for editing and printing.

### ID Generator
- Allows admins to generate barangay IDs by entering the user's name, address, and emergency contact details.

### Admin Credentials
- Provides options for admins to update their credentials, which can only be done once daily.

### Logout
- Logs out the admin and redirects them to the login page.

## Scope and Delimitation

- **Scope**:
  - Develop a web-based system to handle, process, and track document requests.
  - Create a user-friendly interface for residents to easily access and submit document requests.
  - Implement a notification system for request status updates.
  - Secure user data to ensure confidentiality and integrity.

- **Delimitations**:
  - Focuses only on handling current document requests, not maintaining older records.
  - Supports only online requests, excluding in-person requests.
  - Does not interact with other government systems; functions as a standalone system.

## Technologies Used

- **XAMPP**: For local server management.
- **Visual Studio Code**: Code editor.
- **FPDF**: PDF generation library.
- **PHP**: Server-side scripting.
- **CSS**: Styling.
- **JavaScript (JS)**: Dynamic behavior.
- **HTML**: Markup language.
- **Bootstrap v5.3**: Responsive design framework.

**Note**: This project was developed for a specific barangay as part of the course *Information Management* and was completed as a group project by *Group 2*.