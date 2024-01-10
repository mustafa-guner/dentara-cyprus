# Dentara Cyprus
Appointment based clinical web application for dentists. This project is built using Laravel **v10.10** and PHP **v8.1** 

### System Requirements:
- **Authentication & Authorization**
    - Email & Password
    - Admin Dashboard
- **Equipment Stock & Management System**
  - **Surgery Equipments**
    - System will help to organize stock of the surgery tools and equipments.
  - **Reports:**
    - Daily/Weekly/Monthly/Yearly reports will be provided on the appointments and treatments applied.
  - Payments
- **Role Based Management System**
    - **Roles:** There are 2 types of roles in the system.
        - **Admin:** A role where it gives more privileges to the assigned user.
        - **Standard User:** Default user role with restricted privileges.
    - **User (Employee) Types:** There are 3 types of employees in the system.
        - System Users - (Employees)
        - Nurses
        - Doctors
    - Target System Entities & Others
        - Appointments
        - Patients
        - **Treatments:** There are more than 2 types of treatments in the system. But the important ones are;
          - Medicine
          - Surgery


### Dashboard Abilities:

Each group of user should have some specific role in the system. They are not allowed to take an action outside of their given roles and authorization.

#### Authentication & Authorization

**Common Authentication (Admin/Employee/Nurse/Doctors):**

- As a  system user regardless of my role i should be able to log into system by entering my email/username and password.
- As a system user i should get an error if the credentials i entered are wrong.
- As a system user i should be able to reset my password by entering the verification code that is sent to to my verified email box if the email address i entered is valid and belongs to me.


**Authorization:**

Roles:
 - Admin:
    -   Admin is a role where it  gives more privileges to assigned employee.
    - As an admin i should be able to manage the employees such as doctors, system users and nurses as follows;
      - Create new employee
      - Edit existed employee
      - Delete the employe
   - For example as an admin i should be able to create a user account for new nurse/doctor or employee. And the likewise, i should be able to edit and remove the accounts accordingly when the employee left the job.
   - Also as an admin i should be the one who access to sensitive employee informations.
- Employee Types:
  - There are 3 types of Employees. All employee types should be able to ssee their personal information as default when then enter the system.
    - Doctors:
      - As a doctor i should be able to check how many appointments i have today.
      - As a doctor i should be able to see the appointment details (patient and the complain etc)
      - As a doctor i should be able to access to past appointment records of my patients.
    - Nurses
      - As a nurse i should be able to check daily appointment schedule of the doctors.
      - As a nurse  i should be able
    - System User:
      - As a system user i should be able to manage appointments and have full access to database to see calendar of the appointments/patients and treatments with the details.
      - As a system user i should be able to send reminder message to patients those who have upcoming appointments manually. (Apart from the automation)
      - Create new appointment for both new and existed patients
      - Edit existed appointment (adjust the date time and status of the appointment)
      - Remove the appointment
      - Details of appointment
      - As a system user i should be able to manage the patients and their details and see past treatments with appointments.
      - Create new patient
      - Edit existed patient
      - Remote the patient
      - Details of the patient


### Target System Entities:
**Appointment:**
- Appointment can have the following fields;

  - Patient
  - Start Date/Time
  - Status (In Progress / Suspended / Canceled / Completed)
  - Complain
  - Discount Rate
  - Appointment Type
  - Payment Method (Cash/Card)
  - Payment Status
  - Price
  - Total Price 
- Appointment can only have ONE patient at a time.
- Appointment should have start date and time
- Appointment should have status field to differantiate the appointments by the status. When the appointment is created, default status will be in progress and payment status will be waiting for payment. Patient may call and cancel the appointment or ask to suspend it to future date. Whenever the payment is done, payment status should be updated as paid appointment status should be switched to completed.
- Appointment may have a complain where patient can tell what is the problem they are having. This field will be sent to doctor when the appointment is begun.
- An appointment should have a field called "weight" to differentiate appointments based on their emergency status. As the number of reservations increases, it becomes imperative to impose restrictions. A daily reservation schedule needs to be established, which will be determined based on the weights assigned to appointments on a scale of 1 to 5. Urgent appointments will carry a weight of 4 out of 5. Additionally, there will be various appointment types, each corresponding to a specific treatment or check-up. These appointment types will help define the nature and duration of each appointment in a given day. This categorization enables clinic employees to effectively organize their schedules. In instances where there are no appointments with weights of 4 or 5 (considered prioritized), the day may include more normal appointments (with a weight of 3 or less).
- When appointment is created for the patient, it should be assigned to one doctor.
- Pricing is based on the treatment patient get during the appointment. For example, if patient is a new patient and doctor needs to see the X-RAY of the patient, doctor has to use X-RAY machine which will cost patient more price. This price will be handled under treatment. Basically each treatment and appointment type will be having different pricing strategy and cost.
- Appointment can have more than one treatments. (Medicine + Surgery)
- When appointment ends, system user will be click on the calculate button to see how much patient should pay for the service.
- Appointment may have discount field for those patient who have health insurance to make some discounts. With that, if patient has discount price will be down accordingly.
- Appointment should have payment method for accounting report purposes. Since the appointment will be created based on the phone call, these fields will be created as null until the end of the appointment.
- Appointment should have price field to display the price of appointment without discount. With that system users will be able to see the discount rates and the real price to calculate all the ROI with valuable datasets.
- Appointment should have a total price to display the calculated price over defined discount rate (if there is any).



**Appointment Type:**

Appointment Type(s) can have the following fields;

- Title
- Description
- Price

As mentioned earlier, the pricing strategy will depend on the appointment and treatment types; therefore, appointment types will have a price field. Appointment types will also define the duration of the appointments.

**Treatment:**

Treatment(s) can have the following fields;
- Treatment Type
- Equipment
- Comment.
Equipment details will be stored in the treatment table to display the treatments with the associated equipment used.
Each treatment may include comments, which will be recorded by the doctor/nurse during the appointment.

**Treatment Type:**

Treatment Type(s) can have the following fields;
- Title
- Description
- Price
Each treatment will be associated with a treatment type, which will determine the price based on the type.

**Appointment Treatments:**

- Appointment Treatment(s) can have the following fields;
- Appointment
- Treatment
- User (Doctor/Nurse/Assistant)

Appointment treatments will serve as the intermediary table. This table will store all the treatments applied during the appointment. The user field will enable system users to track which individuals performed specific treatments for each appointment.


**Patient:**

Patient(s) can have the following fields;

- Firstname
- Lastname
- Gender
- Phone no
- Address
- Age (Date of Birth)

Patient(s) may have more than one appointments.
All the previous appointment records of the patient will be saved in the system. This will give more reliable service to our patients by knowing and following their cure processes closely.
System will be sending a reminder SMS messages to our patients to remind them the incoming appointment. This will allow us to notify our patients.

**Equipments:**

Equipment(s) can have the following fields;
- Definition
- Quantity

By adding the quantity information into equipments table will give system users an advantage where they will be able to track the stock of the items. Since some items will be one-time use, these will be decrease every time crew uses it. When it is about to out of stock, basically the system will be thrown a notify to re-stock all the required items.
Equipments are related with treatments. System users will be able to track the usage of equipments during the appointment as some of treatments require some equipments to use.
  
  <hr>

### Summary:

The system described in this report incorporates comprehensive dashboard abilities, emphasizing strict role-based access control for users. Authentication and authorization processes are defined for common users (Admin/Employee/Nurse/Doctors), ensuring secure login and password recovery.

The Authorization section elaborates on the roles and permissions of Admins, Doctors, Nurses, and System Users. Admins, with enhanced privileges, can manage employees, create, edit, and delete accounts, and access sensitive employee information. Each employee type, including Doctors and Nurses, has specific functionalities tailored to their roles, such as checking appointments, viewing patient details, and managing daily schedules.

The report identifies target system entities, focusing on the Appointment entity. Key fields include patient details, start date/time, status, complain, discount rate, appointment type, payment method, payment status, price, and total price. The appointment system incorporates a weight system to prioritize urgent cases, appointment types for different treatments, and a pricing strategy based on treatments and appointment types.

Appointment Treatments, as an intermediary table, includes fields for appointment, treatment, and user (Doctor/Nurse/Assistant). This table facilitates the tracking of treatments performed during appointments and the responsible individuals.

The Treatment and Treatment Type entities provide additional details, such as equipment, comments, and pricing, contributing to a comprehensive record of patient care. In summary, the described system aims to streamline appointment management, enhance user-specific functionalities, and maintain a detailed record of treatments and appointments for efficient healthcare administration.
