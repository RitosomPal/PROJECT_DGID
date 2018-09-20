<?php
    include_once('./config/Database.php');

    class Department {
        // Class Variable
        private $database;

        // College Department Info
        private $reg;
        private $code;
        private $name;
        private $contact;
        private $email;
        private $hod;

        public function __construct($clgReg) {
            $this->database = new Database();
            $this->reg = htmlspecialchars(strip_tags($clgReg));
        }

        # Creating Department 
        public function create($post) {
            extract($post);

            // Clean Data
            $this->name = htmlspecialchars(strip_tags($deptName));
            $this->code = htmlspecialchars(strip_tags($deptCode));
            $this->contact = htmlspecialchars(strip_tags($deptContact));
            $this->email = htmlspecialchars(strip_tags($deptEmail));

            // All sql commands
            $sql0 = 'SELECT * FROM dept WHERE code = :code';
            $sql1 = 'INSERT INTO dept SET code = :code, name = :name, contact= :contact, email = :email';
            $sql2 = 'CREATE DATABASE '.$this->reg.'_'.$this->code;
            $sql3 = 'CREATE TABLE '.$this->reg.'_'.$this->code.' . faculties ( id INT NOT NULL AUTO_INCREMENT ,  empid VARCHAR(255) NOT NULL ,  name TEXT NOT NULL ,  contact BIGINT NOT NULL ,  email VARCHAR(255) NOT NULL ,  address TEXT NOT NULL ,  dob VARCHAR(255) NOT NULL ,  doj VARCHAR(255) NOT NULL ,  experience TEXT NOT NULL ,    PRIMARY KEY  (id, empid)) ENGINE = InnoDB';
            $sql4 = 'CREATE TABLE '.$this->reg.'_'.$this->code.' . students ( id INT NOT NULL AUTO_INCREMENT ,  uid VARCHAR(255) NOT NULL , sem INT NOT NULL  , year INT NOT NULL ,  name TEXT , dob VARCHAR(255) , gender TEXT ,  contact BIGINT ,  email VARCHAR(255) ,  present_address MEDIUMTEXT , district TEXT , blood_grp VARCHAR(255) , birth_mark TEXT , birth_place TEXT, physically_challenged TEXT , caste TEXT , religion TEXT , aadhar VARCHAR(255) , kanyashree VARCHAR(255) , mdk_scl_name TEXT , mdk_scl_district TEXT , mdk_board_name TEXT , mdk_passing_year INT , mdk_reg_no VARCHAR(255) , mdk_roll VARCHAR(255) , mdk_no VARCHAR(255) , mdk_physics_marks FLOAT , mdk_maths_marks FLOAT , mdk_aggreagate_marks FLOAT , mdk_full_marks FLOAT , mdk_percent FLOAT , mdk_division TEXT , hs_scl_name TEXT , hs_scl_district TEXT , hs_board_name TEXT , hs_passing_year INT , hs_reg_no VARCHAR(255) , hs_roll VARCHAR(255) , hs_no varchar(255) , hs_aggreagate_marks FLOAT , hs_full_marks FLOAT , hs_percent FLOAT , hs_division TEXT , father_name TEXT , mother_name TEXT , guardian_non_parent TEXT , guardian_non_parent_relation TEXT , guardian_contact TEXT , guardian_email TEXT , guardian_present_address TEXT , guardian_permanent_address MEDIUMTEXT , guardian_occupation TEXT , PRIMARY KEY  (id, uid)) ENGINE = InnoDB';
            $sql5 = 'CREATE TABLE '.$this->reg.'_'.$this->code.'. subjects ( id INT NOT NULL AUTO_INCREMENT ,  code INT NOT NULL ,  sem INT NOT NULL ,  name TEXT NOT NULL , empid VARCHAR(255) , PRIMARY KEY  (id)) ENGINE = InnoDB';
            $sql6 = 'CREATE TABLE '.$this->reg.'_'.$this->code.'. library ( id INT NOT NULL AUTO_INCREMENT ,  link MEDIUMTEXT NOT NULL ,  name TEXT NOT NULL ,    PRIMARY KEY  (id)) ENGINE = InnoDB';
            
            // Checking For Department Existence
            $db = $this->reg.'_details';
            $conn = $this->database->connectSpec($db);
            $stmt = $conn->prepare($sql0);
            $stmt->bindParam(':code', $this->code);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }
            if ($stmt->rowCount() != 0) {
                return "Department already exist!";
            }

            // Inserting Data into dept Table under College Database
            $stmt = $conn->prepare($sql1);
            $stmt->bindParam(':code', $this->code);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':contact', $this->contact);
            $stmt->bindParam(':email', $this->email);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }

            // Create Department Database
            $stmt = $conn->prepare($sql2);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }

            // Creating Faculty Table in Department Database
            $db = $this->reg.'_'.$this->code;
            $conn = $this->database->connectSpec($db);
            $stmt = $conn->prepare($sql3);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }

            // Creating Student Table in Department Database
            $db = $this->reg.'_'.$this->code;
            $conn = $this->database->connectSpec($db);
            $stmt = $conn->prepare($sql4);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }

            // Creating Subject Table in Department Database
            $db = $this->reg.'_'.$this->code;
            $conn = $this->database->connectSpec($db);
            $stmt = $conn->prepare($sql5);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }

            // Creating Library Table in Department Database
            $db = $this->reg.'_'.$this->code;
            $conn = $this->database->connectSpec($db);
            $stmt = $conn->prepare($sql6);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }

            return true;
        }

        # Get Department Names
        public function names() {
            // SQL commands
            $sql0 = 'SELECT code, name FROM dept';

            // Getting Info
            $db = $this->reg.'_details';
            $conn = $this->database->connectSpec($db);
            $stmt = $conn->prepare($sql0);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }
            return $stmt->fetchAll();
        }

        # Department Info Output
        public function info($code) {
            $this->code = htmlspecialchars(strip_tags($code));

            // SQL command
            $sql0 = 'SELECT * FROM dept WHERE code = :code';

            // Getting Info
            $db = $this->reg.'_details';
            $conn = $this->database->connectSpec($db);
            $stmt = $conn->prepare($sql0);
            $stmt->bindParam(':code', $this->code);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }
            return $stmt->fetchAll();
        }

        # update Department Info
        public function update($post) {
            extract($post);

            // Clean Data
            $this->name = htmlspecialchars(strip_tags($deptName));
            $this->code = htmlspecialchars(strip_tags($deptCode));
            $this->contact = htmlspecialchars(strip_tags($deptContact));
            $this->email = htmlspecialchars(strip_tags($deptEmail));
            $this->hod = htmlspecialchars(strip_tags($deptHod));

            // SQL commands
            $sql0 = 'UPDATE dept SET contact = :contact, email = :email, name = :name, hod = :hod WHERE code = :code';

            if ($this->hod == '') {
                $this->hod = null;
            }

            // Updating Info
            $db = $this->reg.'_details';
            $conn = $this->database->connectSpec($db);
            $stmt = $conn->prepare($sql0);
            $stmt->bindParam(':contact', $this->contact);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':code', $this->code);
            $stmt->bindParam(':hod', $this->hod);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }

            return true;
        }

    }