# Dentara Cyprus
Appointment-based clinical web application for dentists. This project is built using Laravel **v10.10** and PHP **v8.1** 

### System Requirements:
- **Authentication & Authorization**
    - Email & Password
    - Admin Dashboard
- **Equipment Stock & Management System**
  - **Surgery Equipments**
    - System will help to organize stock of the surgery tools and equipment.
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

Each group of users should have some specific role in the system. They are not allowed to take an action outside of their given roles and authorization.

#### Authentication & Authorization

**Common Authentication (Admin/Employee/Nurse/Doctors):**

- As a  system user regardless of my role I should be able to log into the system by entering my email/username and password.
- As a system user I should get an error if the credentials I entered are wrong.
- As a system user I should be able to reset my password by entering the verification code that is sent to my verified email box if the email address I entered is valid and belongs to me.


**Authorization:**

Roles:
 - Admin:
    -   Admin is a role where it  gives more privileges to assigned employees.
    - As an admin, I should be able to manage the employees such as doctors, system users, and nurses as follows;
      - Create new employee
      - Edit existing employee
      - Delete the employee
   - For example, as an admin, I should be able to create a user account for new nurses/doctors or employees. Likewise, I should be able to edit and remove the accounts accordingly when the employee leaves the job.
   - Also as an admin, I should be the one who accesses sensitive employee information.
- Employee Types:
  - There are 3 types of Employees. All employee types should be able to see their personal information by default when they enter the system.
    - Doctors:
      - As a doctor, I should be able to check how many appointments I have today.
      - As a doctor, I should be able to see the appointment details (patient and the complaint, etc)
      - As a doctor, I should be able to access past appointment records of my patients.
    - Nurses
      - As a nurse, I should be able to check the daily appointment schedule of the doctors.
      - As a nurse,  I should be able
    - System User:
      - As a system user I should be able to manage appointments and have full access to the database to see the calendar of the appointments/patients and treatments with the details.
      - As a system user I should be able to send reminder messages to patients who have upcoming appointments manually. (Apart from the automation)
      - Create new appointments for both new and existing patients
      - Edit existing appointment (adjust the date time and status of the appointment)
      - Remove the appointment
      - Details of appointment
      - As a system user I should be able to manage the patients and their details and see past treatments with appointments.
      - Create new patient
      - Edit existing patient
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
- Appointment should have a start date and time
- Appointments should have a status field to differentiate the appointments by status. When the appointment is created, the default status will be in progress and payment status will be waiting for payment. The patient may call and cancel the appointment or ask to suspend it to a future date. Whenever the payment is done, the payment status should be updated and the paid appointment status should be switched to completed.
- Appointment may have a complaint where the patient can tell what the problem they are having. This field will be sent to the doctor when the appointment is begun.
- An appointment should have a field called "weight" to differentiate appointments based on their emergency status. As the number of reservations increases, it becomes imperative to impose restrictions. A daily reservation schedule needs to be established, which will be determined based on the weights assigned to appointments on a scale of 1 to 5. Urgent appointments will carry a weight of 4 out of 5. Additionally, there will be various appointment types, each corresponding to a specific treatment or check-up. These appointment types will help define the nature and duration of each appointment on a given day. This categorization enables clinic employees to effectively organize their schedules. In instances where there are no appointments with weights of 4 or 5 (considered prioritized), the day may include more normal appointments (with a weight of 3 or less).
- When an appointment is created for the patient, it should be assigned to one doctor.
- Pricing is based on the treatment the patient gets during the appointment. For example, if the patient is a new patient and the doctor needs to see the X-RAY of the patient, the doctor has to use an X-RAY machine which will cost the patient more price. This price will be handled under treatment. Each treatment and appointment type will have having different pricing strategy and cost.
- Appointments can have more than one treatment. (Medicine + Surgery)
- When the appointment ends, the system user will click on the calculate button to see how much the patient should pay for the service.
- Appointment may have a discount field for that patient who has health insurance to make some discounts. With that, if the patient has a discount price will be down accordingly.
- Appointment should have a payment method for accounting report purposes. Since the appointment will be created based on the phone call, these fields will be created as null until the end of the appointment.
- Appointment should have a price field to display the price of an appointment without discount. With that system, users will be able to see the discount rates and the real price to calculate all the ROI with valuable datasets.
- Appointment should have a total price to display the calculated price over the defined discount rate (if there is any).



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

Patient(s) may have more than one appointment.
All the previous appointment records of the patient will be saved in the system. This will give more reliable service to our patients by knowing and following their cure processes closely.
The system will be sending reminder SMS messages to our patients to remind them of the incoming appointment. This will allow us to notify our patients.

**Equipment:**

Equipment(s) can have the following fields;
- Definition
- Quantity

Adding the quantity information to the equipment table will give system users an advantage where they will be able to track the stock of the items. Since some items will be one-time use, these will be decreased every time the crew uses them. When it is about to be out of stock, basically the system will be thrown a notification to re-stock all the required items.
Equipments are related to treatments. System users will be able to track the usage of equipment during the appointment as some treatments require some types of equipment to use.
  
  <hr>

### Summary:

The system described in this report incorporates comprehensive dashboard abilities, emphasizing strict role-based access control for users. Authentication and authorization processes are defined for common users (Admin/Employee/Nurse/Doctors), ensuring secure login and password recovery.

The Authorization section elaborates on the roles and permissions of Admins, Doctors, Nurses, and System Users. Admins, with enhanced privileges, can manage employees, create, edit, and delete accounts, and access sensitive employee information. Each employee type, including Doctors and Nurses, has specific functionalities tailored to their roles, such as checking appointments, viewing patient details, and managing daily schedules.

The report identifies target system entities, focusing on the Appointment entity. Key fields include patient details, start date/time, status, complaint, discount rate, appointment type, payment method, payment status, price, and total price. The appointment system incorporates a weight system to prioritize urgent cases, appointment types for different treatments, and a pricing strategy based on treatments and appointment types.

Appointment Treatments, as an intermediary table, includes fields for appointment, treatment, and user (Doctor/Nurse/Assistant). This table facilitates the tracking of treatments performed during appointments and the responsible individuals.

The Treatment and Treatment Type entities provide additional details, such as equipment, comments, and pricing, contributing to a comprehensive record of patient care. In summary, the described system aims to streamline appointment management, enhance user-specific functionalities, and maintain a detailed record of treatments and appointments for efficient healthcare administration.



![image](https://github.com/mustafa-guner/dentara-cyprus/assets/60453650/33cf8423-9bf8-4b28-99ed-fe87bc3e9165)


