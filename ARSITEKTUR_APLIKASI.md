# 🏗️ ARSITEKTUR APLIKASI - SISTEM MANAJEMEN DANA ZAKAT (FUNDMIL)

**Tanggal**: 1 Juni 2026  
**Versi**: 1.0

---

## 📑 DAFTAR ISI

1. [Arsitektur Keseluruhan](#arsitektur-keseluruhan)
2. [Komponen Utama](#komponen-utama)
3. [Database Schema Architecture](#database-schema-architecture)
4. [User Flows & Process](#user-flows--process)
5. [Module/Feature Architecture](#modulefeature-architecture)
6. [API Layer Architecture](#api-layer-architecture)
7. [Authentication & Authorization](#authentication--authorization)
8. [Data Flow Diagram](#data-flow-diagram)
9. [Technology Stack](#technology-stack)
10. [Security Architecture](#security-architecture)

---

## 🎯 Arsitektur Keseluruhan

```
┌─────────────────────────────────────────────────────────────┐
│                    PRESENTATION LAYER                        │
│         (Web UI - Laravel Blade / Vue.js)                   │
│  ┌─────────────────┬──────────────────┬────────────────┐   │
│  │  Super Admin    │  Admin Instansi  │  Petugas       │   │
│  │  Dashboard      │  Dashboard       │  Dashboard     │   │
│  └─────────────────┴──────────────────┴────────────────┘   │
└──────────────────────────────────┬──────────────────────────┘
                                   │
┌──────────────────────────────────▼──────────────────────────┐
│                   APPLICATION LAYER                         │
│              (Laravel Controllers & Services)               │
│  ┌──────────────┬──────────────┬──────────────────────┐    │
│  │ Auth Module  │ Admin Module │ Core Business Logic │    │
│  │ Users        │ Settings     │ Zakat Processing    │    │
│  │ Permissions  │ Reporting    │ Distributions       │    │
│  └──────────────┴──────────────┴──────────────────────┘    │
└──────────────────────────────────┬──────────────────────────┘
                                   │
┌──────────────────────────────────▼──────────────────────────┐
│                   BUSINESS LOGIC LAYER                      │
│           (Services, Validators, Repositories)             │
│  ┌──────────────┬──────────────┬──────────────────────┐    │
│  │ Transaction  │ Distribution │ Calculation Engine  │    │
│  │ Management   │ Management   │ (Nishab, Harga)    │    │
│  │ Mustahik     │ Program      │                     │    │
│  │ Management   │ Management   │                     │    │
│  └──────────────┴──────────────┴──────────────────────┘    │
└──────────────────────────────────┬──────────────────────────┘
                                   │
┌──────────────────────────────────▼──────────────────────────┐
│                    DATABASE LAYER                           │
│                    (MySQL/MariaDB)                          │
│  ┌──────────────┬──────────────┬──────────────────────┐    │
│  │ Master Data  │ Transactions │ Audit & Logs        │    │
│  │ Tables       │ Tables       │ Tables              │    │
│  └──────────────┴──────────────┴──────────────────────┘    │
└─────────────────────────────────────────────────────────────┘
```

---

## 🧩 Komponen Utama

### 1. **Authentication Module**
```
Login Page
    ↓
Auth Controller
    ↓
User Repository
    ↓
Database (Users Table)
    ↓
Session Management
    ↓
Dashboard (Role-based Redirect)
```

**Komponen**:
- LoginController
- AuthService
- UserRepository
- Middleware (Role, Permission)

---

### 2. **User Management Module**
```
Admin Dashboard
    ↓
User Management Page
    ↓
User CRUD Controller
    ↓
User Service
    ↓
User Repository
    ↓
Database (Users + Instansi)
```

**Fitur**:
- Create User (Super Admin)
- Edit User Profile
- Manage Permissions
- User Status (Active, Blocked, Pending)
- Instansi Assignment

---

### 3. **Instansi Management Module**
```
Super Admin Dashboard
    ↓
Instansi Management
    ↓
Instansi CRUD Operations
    ↓
Instansi Service
    ↓
Database (Instansi + Related)
    ├── Profile Fields
    ├── Rekening Instansi
    └── Profil Notifications
```

**Fitur**:
- CRUD Instansi
- Profile Settings
- Bank Account Management
- Notification Preferences
- Profile Photo Upload

---

### 4. **Zakat Reception Module**
```
Admin Instansi / Petugas
    ↓
Create Transaksi Zakat
    ↓
Transaksi Form (Muzakki, Kategori, Jumlah)
    ↓
Validation & Business Logic
    ├── Nishab Checking
    ├── Harga Beras Reference
    └── Receipt Generation
    ↓
Save to Database
    ├── Transaksi Zakat
    ├── Payment Proof Upload
    └── Generate Receipt Number
    ↓
Report Generation
```

**Data Needed**:
- Muzakki Name
- Category (Zakat, Infak, Sedekah)
- Sub-Category (Beras, Uang)
- Amount
- Payment Method
- Payment Proof

---

### 5. **Mustahik Management Module**
```
Admin Instansi
    ↓
Mustahik Database
    ↓
Register/Verify Mustahik
    ├── Basic Info (NIK, Name, Address)
    ├── Category (8 Asnaf)
    └── Location (GPS)
    ↓
Verification Status
    ├── Pending
    ├── Verified
    └── Rejected
    ↓
Database Storage
```

**Asnaf Categories**:
1. Fakir
2. Miskin
3. Amil
4. Muallaf
5. Riqab
6. Gharimin
7. Fisabilillah
8. Ibnu Sabil

---

### 6. **Program Penyaluran Module**
```
Admin Instansi
    ↓
Create Program
    ├── Program Name
    ├── Start/End Date
    ├── Distribution Method
    └── Target Amount
    ↓
Program Status (Draft → Active → Completed)
    ↓
Approval Workflow
    ├── Draft Status
    ├── Submit for Approval
    ├── Super Admin Review
    └── Approve/Reject with Notes
    ↓
Active Program
    ↓
Create Penyaluran (Distribution)
```

---

### 7. **Penyaluran (Distribution) Module**
```
Program Penyaluran (Active)
    ↓
Create Distribution Event
    ├── Date
    ├── Location/Venue
    ├── Notes
    └── Photo Proof
    ↓
Add Distribution Details
    ├── Penerima Type (Individu/Keluarga/Lembaga)
    ├── Link ke Mustahik (optional)
    ├── Amount per Person/Entity
    └── Receipt Status
    ↓
Mark as Completed
    └── Generate Report with Photos
```

---

### 8. **Reporting & Analytics Module**
```
Dashboard
    ↓
Report Types
    ├── Zakat Reception Report
    │   ├── Total by Category
    │   ├── Total by Payment Method
    │   └── Donor List
    ├── Distribution Report
    │   ├── Distribution by Program
    │   ├── Distribution by Asnaf
    │   └── Beneficiary List
    ├── Financial Report
    │   ├── Nishab Compliance
    │   ├── Fund Balance
    │   └── Transaction History
    └── Organization Report
        ├── Program Progress
        ├── Approval Status
        └── Performance Metrics
```

---

## 🗄️ Database Schema Architecture

### Entity Relationship Overview

```
INSTANSI (Central Hub)
│
├─── Users (Admin/Petugas)
│
├─── Kategori Dana (Classification)
│    │
│    └─── Transaksi Zakat (Receipts)
│
├─── Mustahik (Beneficiaries)
│    │
│    └─── Penyaluran Detail (Distribution Recipients)
│
├─── Program Penyaluran (Distribution Programs)
│    │
│    ├─── Penyaluran (Distribution Events)
│    │    │
│    │    └─── Penyaluran Detail (Individual Recipients)
│
├─── Rekening Instansi (Bank Accounts)
│
└─── Profil Instansi Notifications (Notifications)

Master Data (Shared):
├─── Harga Beras (Rice Price Reference)
└─── Nishab (Zakat Threshold Reference)
```

### Data Flow Through Tables

```
1. ZAKAT RECEPTION FLOW:
   Muzakki → Transaksi Zakat → Kategori Dana
                ↓
           Harga Beras Snapshot
                ↓
           Nishab Checking

2. BENEFICIARY REGISTRATION:
   Admin Input → Mustahik → Verification Process → Status Update

3. DISTRIBUTION FLOW:
   Program Penyaluran (Approved)
           ↓
   Create Penyaluran Event
           ↓
   Add Penyaluran Detail (Per Beneficiary)
           ↓
   Mark Distribution Status
           ↓
   Generate Report
```

---

## 👥 User Flows & Process

### Admin Super Admin Flow
```
┌─ Super Admin Login
├─ Super Admin Dashboard
├─ Manage Instansi
│  ├─ Create/Edit/Delete Instansi
│  └─ View Instansi Details
├─ Manage Users
│  ├─ Create Admin per Instansi
│  └─ Manage Permissions
├─ Manage Master Data
│  ├─ Set Harga Beras
│  ├─ Set Nishab
│  └─ Configure System Settings
├─ Review & Approve Programs
│  ├─ View Program Penyaluran
│  ├─ Approve/Reject with Notes
│  └─ Monitor Approvals Status
└─ System Reports
   ├─ All Transactions (All Instansi)
   ├─ All Distributions
   └─ Overall Statistics
```

### Admin Instansi Flow
```
┌─ Admin Instansi Login
├─ Dashboard (Instansi-specific)
├─ Manage Profile
│  ├─ Edit Instansi Data
│  ├─ Manage Bank Accounts
│  └─ Upload Logo & Signature
├─ Manage Users (Petugas)
│  ├─ Add Petugas
│  └─ Manage Petugas Account
├─ Master Data Management (Local)
│  ├─ Create Kategori Dana
│  └─ Create/Manage Mustahik
├─ Create Transaksi Zakat
│  ├─ Input Donor Data
│  ├─ Record Amount
│  ├─ Upload Proof
│  └─ Generate Receipt
├─ Create Program Penyaluran
│  ├─ Fill Program Details
│  ├─ Submit for Approval (to Super Admin)
│  └─ Monitor Approval Status
├─ Create Penyaluran (if Program Approved)
│  ├─ Select Program
│  ├─ Add Distribution Details
│  ├─ Upload Photo Proof
│  └─ Mark Complete
└─ View Reports
   ├─ Zakat Reception
   ├─ Distribution History
   ├─ Beneficiary List
   └─ Financial Summary
```

### Petugas Flow
```
┌─ Petugas Login
├─ Dashboard (View Only/Limited)
├─ Create Transaksi Zakat (if permitted)
│  ├─ Input Donor Information
│  ├─ Record Amount
│  └─ Generate Receipt
├─ Register Mustahik
│  ├─ Input Basic Info
│  ├─ Set Asnaf Category
│  └─ Mark for Verification
├─ Input Distribution Data
│  ├─ Record Distribution Event
│  ├─ Add Individual Recipients
│  └─ Mark Receipt Status
└─ View Reports (Limited to assigned tasks)
```

---

## 📦 Module/Feature Architecture

```
├── AUTH MODULE
│   ├── Login/Logout
│   ├── Role-based Access
│   ├── Permission Management
│   └── Session Management
│
├── MASTER DATA MODULE
│   ├── Instansi Management
│   ├── User Management
│   ├── Kategori Dana Management
│   ├── Mustahik Database
│   ├── Harga Beras Management (Super Admin)
│   └── Nishab Management (Super Admin)
│
├── ZAKAT TRANSACTION MODULE
│   ├── Create Transaksi Zakat
│   ├── Receipt Generation
│   ├── Payment Proof Upload
│   ├── Snapshot Harga Beras
│   └── Transaction Validation
│
├── BENEFICIARY MODULE
│   ├── Register Mustahik
│   ├── Verify Mustahik
│   ├── Categorize by Asnaf
│   ├── Location Mapping (GPS)
│   └── Beneficiary List
│
├── PROGRAM MODULE
│   ├── Create Program
│   ├── Program Approval Workflow
│   ├── Approval Status Tracking
│   ├── Distribution Method Setup
│   └── Target Amount Management
│
├── DISTRIBUTION MODULE
│   ├── Create Distribution Event
│   ├── Add Distribution Recipients
│   ├── Receipt Tracking (Received/Rejected/Pending)
│   ├── Photo Documentation
│   └── Completion Marking
│
├── REPORTING MODULE
│   ├── Zakat Reception Reports
│   ├── Distribution Reports
│   ├── Financial Reports
│   ├── Beneficiary Analytics
│   └── Export Reports (PDF/Excel)
│
└── NOTIFICATION MODULE
    ├── Program Status Notifications
    ├── Approval Notifications
    ├── System Notifications
    └── Email Notifications
```

---

## 🔌 API Layer Architecture

### Proposed REST API Endpoints

```
AUTH
├── POST /api/login
├── POST /api/logout
└── GET /api/me

INSTANSI
├── GET /api/instansi (Super Admin only)
├── POST /api/instansi
├── GET /api/instansi/{id}
├── PUT /api/instansi/{id}
└── DELETE /api/instansi/{id}

USERS
├── GET /api/users (Role-based)
├── POST /api/users
├── GET /api/users/{id}
├── PUT /api/users/{id}
└── DELETE /api/users/{id}

KATEGORI DANA
├── GET /api/kategori-dana
├── POST /api/kategori-dana
├── GET /api/kategori-dana/{id}
├── PUT /api/kategori-dana/{id}
└── DELETE /api/kategori-dana/{id}

TRANSAKSI ZAKAT
├── GET /api/transaksi-zakat
├── POST /api/transaksi-zakat
├── GET /api/transaksi-zakat/{id}
├── PUT /api/transaksi-zakat/{id}
└── DELETE /api/transaksi-zakat/{id}

MUSTAHIK
├── GET /api/mustahik
├── POST /api/mustahik
├── GET /api/mustahik/{id}
├── PUT /api/mustahik/{id}
├── PATCH /api/mustahik/{id}/verify
└── DELETE /api/mustahik/{id}

PROGRAM PENYALURAN
├── GET /api/program-penyaluran
├── POST /api/program-penyaluran
├── GET /api/program-penyaluran/{id}
├── PUT /api/program-penyaluran/{id}
├── PATCH /api/program-penyaluran/{id}/submit-approval
├── PATCH /api/program-penyaluran/{id}/approve
├── PATCH /api/program-penyaluran/{id}/reject
└── DELETE /api/program-penyaluran/{id}

PENYALURAN
├── GET /api/penyaluran
├── POST /api/penyaluran
├── GET /api/penyaluran/{id}
├── PUT /api/penyaluran/{id}
└── DELETE /api/penyaluran/{id}

PENYALURAN DETAIL
├── GET /api/penyaluran/{penyaluran_id}/detail
├── POST /api/penyaluran/{penyaluran_id}/detail
├── GET /api/penyaluran-detail/{id}
├── PUT /api/penyaluran-detail/{id}
├── PATCH /api/penyaluran-detail/{id}/mark-received
└── DELETE /api/penyaluran-detail/{id}

REPORTS
├── GET /api/reports/zakat-reception
├── GET /api/reports/distributions
├── GET /api/reports/financial
├── GET /api/reports/beneficiaries
└── GET /api/reports/export/{format}

MASTER DATA
├── GET /api/harga-beras
├── POST /api/harga-beras (Super Admin)
├── GET /api/nishab
└── POST /api/nishab (Super Admin)
```

---

## 🔐 Authentication & Authorization

### Role-Based Access Control (RBAC)

```
ROLES:
├── super_admin
│   ├── Manage All Instansi
│   ├── Manage All Users
│   ├── Set Master Data (Harga Beras, Nishab)
│   ├── Approve Programs
│   ├── View All Reports
│   └── System Configuration
│
└── admin_instansi
    ├── Manage Own Instansi Profile
    ├── Manage Own Petugas Users
    ├── Create Transaksi Zakat
    ├── Create/Manage Mustahik
    ├── Create Program Penyaluran (Submit for approval)
    ├── Create/Manage Penyaluran (if approved)
    ├── View Own Reports
    └── Cannot approve programs

(Note: "petugas" role removed, replaced with admin_instansi)
```

### Permission Layers

```
Middleware Chain:
Login → Authenticate → Authorize (Role Check) → Permission Check → Execute

Policy Examples:
├── InstansiPolicy
│   ├── view() → Only Super Admin or Own Admin
│   ├── create() → Super Admin only
│   ├── update() → Own Admin or Super Admin
│   └── delete() → Super Admin only
│
├── TransaksiPolicy
│   ├── create() → Admin Instansi or Petugas of same instansi
│   ├── view() → All role (with instansi filtering)
│   └── delete() → Creator or Admin Instansi
│
└── ProgramPenyaluranPolicy
    ├── create() → Admin Instansi
    ├── approve() → Super Admin only
    └── view() → Role-based filtering
```

---

## 📊 Data Flow Diagram

### Zakat Reception to Distribution Flow

```
DONOR
  ↓
  Provides Zakat/Infak/Sedekah
  ↓
TRANSAKSI ZAKAT CREATED
  ├─ Name
  ├─ Category (Zakat/Infak/Sedekah)
  ├─ Amount
  ├─ Payment Method
  └─ Payment Proof
  ↓
RECEIPT GENERATED
  ├─ Receipt Number
  ├─ Automatic Naming
  └─ Print/Download
  ↓
DATABASE STORED
  └─ Harga Beras Snapshot
  └─ Linked to Kategori Dana
  └─ Linked to Instansi
  ↓
NISHAB CHECKING
  └─ Automatic or Manual Review
  ↓
FUNDS ALLOCATED TO KATEGORI DANA
  ↓
PROGRAM PENYALURAN CREATED
  ├─ Program Name
  ├─ Target Amount
  ├─ Distribution Method
  └─ Start/End Date
  ↓
SUBMIT FOR APPROVAL
  ↓
SUPER ADMIN REVIEWS
  ├─ Checks Program Details
  ├─ Verifies Budget Availability
  └─ Approves/Rejects with Notes
  ↓
IF APPROVED:
  ├─ Status: Approved
  ├─ Can Create Penyaluran Events
  ↓
  CREATE PENYALURAN EVENT
  ├─ Date
  ├─ Venue/Location
  ├─ Photo Documentation
  └─ Distribution Details
  ↓
  ADD PENYALURAN DETAIL
  ├─ For Each Mustahik/Beneficiary
  ├─ Link to Mustahik Database
  ├─ Amount per Recipient
  └─ Receipt Status (Pending/Received/Rejected)
  ↓
  DISTRIBUTION COMPLETED
  ├─ All Recipients Marked
  ├─ Report Generated
  └─ Photo Archive Stored
```

---

## 🛠️ Technology Stack

### Backend
- **Framework**: Laravel 11
- **Language**: PHP 8.2+
- **ORM**: Eloquent
- **Database**: MySQL/MariaDB
- **Queue**: Redis/Beanstalkd
- **Cache**: Redis/File
- **File Storage**: Local/S3

### Frontend
- **Template Engine**: Laravel Blade
- **CSS Framework**: Bootstrap 5 / Tailwind
- **JavaScript**: Vue.js / Alpine.js
- **Forms**: Laravel Collective / Inertia
- **Charts**: Chart.js / Apex Charts
- **Maps**: Google Maps / Leaflet

### Tools & Infrastructure
- **Version Control**: Git
- **Web Server**: Apache/Nginx
- **Development**: Laragon/Valet
- **Testing**: Pest PHP
- **Documentation**: Markdown

### Libraries & Packages
```
Authentication:
├─ Laravel Sanctum (API)
└─ Laravel Fortify (Web Auth)

Validation & Rules:
├─ Laravel Validation
└─ Custom Rules/Validators

File Upload:
├─ Laravel Storage
└─ Intervention Image

Reports:
├─ Laravel Excel
└─ PDF Generation

Utilities:
├─ Carbon (DateTime)
├─ Collections
└─ Logging (Monolog)
```

---

## 🔒 Security Architecture

### Input Validation
```
Request → Validation Rules
├─ Required Fields
├─ Data Type Check
├─ Length/Format Validation
├─ Business Logic Validation
└─ Nishab Compliance Check
```

### Data Protection
```
├─ Password Hashing (Bcrypt)
├─ SQL Injection Prevention (Prepared Statements/Eloquent)
├─ XSS Prevention (Blade Templating)
├─ CSRF Protection (Token Middleware)
├─ HTTPS/SSL Encryption
└─ Data Encryption (Sensitive Fields)
```

### File Upload Security
```
Upload Request → Validation
├─ File Type Check
├─ File Size Limit
├─ Virus Scan (Optional)
└─ Store in Secure Location
```

### Access Control
```
Request → Middleware Stack
├─ Authentication Check
├─ Role Verification
├─ Permission Check
├─ Model Authorization (Policy)
└─ Allow/Deny Access
```

### Audit & Logging
```
├─ User Activity Logs
├─ Transaction Audit Trail
├─ Admin Action Logs
├─ Error Logging
└─ System Event Logging
```

---

## 🔄 Integration Points

### External Integrations (Optional/Future)
```
├─ Bank API Integration
│  └─ Payment Verification
├─ SMS Gateway
│  └─ Notification Delivery
├─ Email Service
│  └─ Receipt & Notification Delivery
├─ WhatsApp API
│  └─ Distribution Notification
└─ Google Maps API
   └─ Location Mapping for Mustahik
```

### Internal Integrations
```
├─ Harga Beras → Transaksi Zakat Snapshot
├─ Nishab → Zakat Calculation
├─ Kategori Dana → Fund Allocation
├─ Mustahik → Penyaluran Detail
└─ Program Approval → Distribution Permission
```

---

## 📈 System Workflows

### Workflow 1: Zakat Reception Workflow
```
1. Input Transaksi Zakat
2. System validates:
   - Kategori Dana exists
   - Amount valid
   - Instansi active
3. Capture Harga Beras snapshot
4. Generate Receipt Number
5. Save to database
6. Display receipt
7. Admin can print/download
```

### Workflow 2: Program Approval Workflow
```
1. Admin Instansi creates Program Penyaluran
2. Set program details (name, date, target, method)
3. Submit for Approval
4. System notifies Super Admin
5. Super Admin reviews:
   - Program feasibility
   - Budget availability
   - Target date validity
6. Super Admin approves/rejects with notes
7. Notification sent to Admin Instansi
8. If approved → Can create Penyaluran events
9. If rejected → Can modify & resubmit
```

### Workflow 3: Distribution Execution Workflow
```
1. Program status = Approved
2. Create Penyaluran event:
   - Select date
   - Set venue/location
   - Add description
   - Upload photo proof
3. Add distribution recipients:
   - Can select from Mustahik database
   - Or input manual recipient
   - Set amount per recipient
4. Mark receipt status:
   - Pending (default)
   - Diterima (received)
   - Ditolak (rejected)
5. Complete penyaluran
6. Generate distribution report
```

### Workflow 4: Mustahik Verification Workflow
```
1. Register Mustahik:
   - Input name, NIK, address
   - Select Asnaf category
   - Optional: Add GPS location
2. Status = Pending (awaiting verification)
3. Admin/Petugas reviews:
   - Verify eligibility
   - Check documentation
4. Update status:
   - Verified (eligible for aid)
   - Rejected (not eligible)
5. Verified Mustahik can receive distributions
```

---

## 📱 Key Features Summary

```
SUPER ADMIN FEATURES:
├─ Instansi Management (CRUD)
├─ User Management (CRUD)
├─ Master Data Configuration
├─ Program Approval
├─ System-wide Reports
├─ Audit Logs
└─ System Settings

ADMIN INSTANSI FEATURES:
├─ Profile Management
├─ User (Petugas) Management
├─ Zakat Reception Tracking
├─ Mustahik Database
├─ Program Creation & Management
├─ Distribution Management
├─ Receipt Generation
└─ Instansi-specific Reports

PETUGAS FEATURES:
├─ View Dashboard
├─ Record Transaksi Zakat (if permitted)
├─ Register Mustahik
├─ Record Distribution Events
└─ Limited Reports View
```

---

## 🎯 Next Steps for Architecture Diagram

**Untuk membuat gambar arsitektur data/sistem, siapkan prompt dengan:**

1. **ER Diagram** (Entity Relationship Diagram)
   - Semua 18 tabel
   - Relationships (1:1, 1:N, N:N)
   - Primary & Foreign Keys
   - Cardinality

2. **System Architecture Diagram**
   - Layers (Presentation, Application, Business Logic, Database)
   - Components per layer
   - Communication paths

3. **Data Flow Diagram (DFD)**
   - User inputs
   - Processing steps
   - Data storage
   - Output/Reports

4. **User Role & Permission Matrix**
   - 3 roles (Super Admin, Admin Instansi, Petugas)
   - Features accessible per role
   - Permissions matrix

5. **Module Interaction Diagram**
   - Module dependencies
   - Data shared between modules
   - API endpoints

6. **Process Flow Diagram**
   - Zakat Reception to Distribution
   - Program Approval Workflow
   - Mustahik Verification Process

7. **Database Schema Relationships**
   - Visual representation
   - Cardinality indicators
   - Key relationships

---

*Dokumentasi ini siap untuk dijadikan prompt membuat gambar arsitektur yang detail dan comprehensive.*

