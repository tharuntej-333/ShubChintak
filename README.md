# Insurance & Scheme Management System

A comprehensive web-based platform for managing government insurance policies and schemes, built with PHP and MySQL. This system allows both users and administrators to effectively manage and access information about various insurance plans and government schemes.

## 🚀 Features

### User Features

#### Authentication & Profile Management
- **User Registration & Login**: Secure user authentication system with password hashing
- **Profile Creation**: Users can create detailed profiles including:
  - Date of birth
  - Gender
  - State of residence
  - Occupation
  - Annual income
  - Marital status
- **Profile-based Filtering**: Automatic filtering of schemes and insurance based on user profile

#### Insurance Management
- **Browse Insurance Plans**: View all available insurance policies
- **Advanced Filtering**: Filter insurance plans by:
  - Policy type
  - Duration (12, 24, 36 months)
  - Income eligibility
  - State
- **Detailed Insurance Information**: View comprehensive details of each insurance plan including:
  - Policy name and description
  - Premium amount
  - Coverage duration
  - Eligibility criteria
  - External links for more information
- **Recent Insurance Policies**: View recently added insurance plans

#### Scheme Management
- **Browse Government Schemes**: Access various government schemes
- **Smart Filtering**: Filter schemes by:
  - Sector (Student, Education, Healthcare, Business, Agriculture, Social Welfare)
  - Gender eligibility
  - State
  - Income requirements
- **Scheme Details**: Comprehensive information about each scheme including:
  - Description and objectives
  - Eligibility criteria
  - Application deadlines
  - Income limits
  - Geographic availability
- **Recent Schemes**: View newly launched schemes

#### Notification System
- **Personalized Notifications**: Get notified about:
  - New schemes matching user profile
  - Insurance policies suitable for user's demographic
  - Schemes based on user's state, occupation, and income
  - Recently launched programs

### Administrative Features

#### Admin Dashboard
- **Secure Admin Login**: Separate authentication system for administrators
- **Complete CRUD Operations**: Full Create, Read, Update, Delete functionality for:
  - Insurance policies
  - Government schemes

#### Insurance Management (Admin)
- **Add New Insurance Plans**: Create new insurance policies with:
  - Policy details and descriptions
  - Premium calculations
  - Eligibility criteria
  - Duration and coverage options
- **Update Insurance Plans**: Modify existing insurance policies
- **Delete Insurance Plans**: Remove outdated or cancelled policies

#### Scheme Management (Admin)
- **Add New Schemes**: Create government schemes with:
  - Sector-specific targeting
  - Gender and income-based eligibility
  - Geographic restrictions
  - Timeline management
- **Update Schemes**: Modify existing scheme details
- **Delete Schemes**: Remove expired or cancelled schemes

## 🛠️ Technology Stack

- **Backend**: PHP 7.4+
- **Database**: MySQL 8.0
- **Frontend**: HTML5, CSS3, JavaScript
- **Server**: Apache (XAMPP/WAMP recommended)
- **Architecture**: MVC-inspired structure with session management

## 📊 Database Structure

The system uses a MySQL database (`DBMSproj`) with the following main tables:

### Core Tables
- **`user_login`**: User authentication credentials
- **`user`**: User profile information
- **`admin`**: Administrator credentials
- **`Insurance`**: Insurance policy details
- **`Schemes`**: Government scheme information
- **`organization`**: Organization details for scheme management

### Key Fields
- **Insurance Table**: `insurance_id`, `policy_name`, `description`, `type`, `duration`, `premium`, `income`, `state`, `start_date`
- **Schemes Table**: `scheme_id`, `scheme_name`, `description`, `sector`, `gender`, `income`, `state`, `start_date`, `end_date`
- **User Table**: `user_id`, `dob`, `gender`, `state`, `occupation`, `income`, `marital_status`

## 🔧 Installation & Setup

### Prerequisites
- XAMPP/WAMP server
- PHP 7.4 or higher
- MySQL 8.0 or higher
- Web browser

### Installation Steps

1. **Clone the Repository**
   ```bash
   git clone [repository-url]
   cd proj
   ```

2. **Database Setup**
   - Start XAMPP/WAMP server
   - Create a new database named `DBMSproj`
   - Import the SQL schema (create the required tables)
   - Update database credentials in `db_connect.php` if needed

3. **Configuration**
   - Ensure the database connection settings in `db_connect.php` match your local setup:
     ```php
     $host = 'localhost';
     $username = 'root';
     $password = '';
     $database = 'DBMSproj';
     $port = 3306;
     ```

4. **Launch Application**
   - Place the project folder in your web server directory (`htdocs` for XAMPP)
   - Access the application via `http://localhost/proj/`

## 🗂️ File Structure

```
proj/
├── index.php                 # Main landing page with login/registration
├── home.php                  # User dashboard after login
├── dashboard.php             # Profile creation page
├── admin_dashboard.php       # Admin control panel
├── db_connect.php           # Database connection configuration
├── logout.php               # Session termination
│
├── Insurance Management/
│   ├── insurance.php         # Browse insurance plans
│   ├── insurance_details.php # Detailed insurance information
│   ├── add_insurance.php     # Admin: Add new insurance
│   └── recent_insurance.php  # Recently added insurance
│
├── Scheme Management/
│   ├── schemes.php           # Browse government schemes
│   ├── scheme_details.php    # Detailed scheme information
│   ├── add_scheme.php        # Admin: Add new scheme
│   └── recent_schemes.php    # Recently added schemes
│
├── Notifications/
│   └── notification.php      # Personalized notifications
│
├── Update Operations/
│   ├── update_insurance.html # Insurance update form
│   ├── update_insurance.php  # Process insurance updates
│   ├── edit_insurance.php    # Insurance edit interface
│   ├── update_scheme.html    # Scheme update form
│   ├── update_scheme.php     # Process scheme updates
│   └── edit_scheme.php       # Scheme edit interface
│
└── Delete Operations/
    ├── delete_insurance.html  # Insurance deletion form
    ├── delete_insurance.php   # Process insurance deletion
    ├── delete_scheme.html     # Scheme deletion form
    └── delete_scheme.php      # Process scheme deletion
```

## 👥 User Roles

### Regular Users
- Browse and filter insurance plans and schemes
- Create and manage personal profiles
- Receive personalized notifications
- View detailed information about policies and schemes

### Administrators
- Full CRUD operations on insurance plans
- Complete scheme management capabilities
- Access to admin dashboard
- Ability to add, update, and delete both insurance and schemes

## 🔒 Security Features

- **Password Hashing**: All user passwords are securely hashed
- **Session Management**: Secure session handling for user authentication
- **SQL Injection Prevention**: Prepared statements for database queries
- **Access Control**: Role-based access for admin and user functionalities
- **Input Validation**: Server-side validation for all user inputs

## 🎯 Key Functionalities

### Smart Filtering System
- **Profile-based Auto-filtering**: Automatically shows relevant schemes and insurance based on user profile
- **Manual Override**: Users can apply additional filters beyond their profile
- **Multi-criteria Filtering**: Complex filtering based on multiple parameters

### Notification Intelligence
- **Eligibility Matching**: Notifies users about schemes they're eligible for
- **Geographic Relevance**: Shows state-specific schemes and insurance
- **Income-based Recommendations**: Suggests plans within user's income range
- **Recent Updates**: Highlights newly added schemes and policies

### Administrative Control
- **Comprehensive Management**: Full control over all schemes and insurance data
- **Bulk Operations**: Efficient management of multiple records
- **Data Integrity**: Ensures consistency across all operations

## 🔄 Workflow

### User Journey
1. **Registration/Login** → **Profile Creation** → **Browse Options** → **Apply Filters** → **View Details** → **Get Notifications**

### Admin Journey
1. **Admin Login** → **Dashboard** → **Choose Operation** (Add/Update/Delete) → **Manage Data** → **Logout**

## 📱 Responsive Design

The system features a clean, responsive design that works across different devices and screen sizes, ensuring accessibility for all users.

## 🤝 Contributing

This project is part of a DBMS coursework. For contributions or suggestions, please follow standard coding practices and ensure all database operations use prepared statements for security.

## 📄 License

This project is developed for educational purposes as part of a Database Management Systems course.

---

**Note**: This system provides a comprehensive platform for managing insurance and government schemes, featuring both user-facing functionalities and administrative controls, built with a focus on security, usability, and data integrity.
