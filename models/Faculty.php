<?php
    include_once('./config/Database.php');
    
    class Faculty {
        // Class Variable
        private $database;

        // Department Faculty Info
        private $reg;
        private $branchCode;
        private $empid;
        private $name;
        private $contact;
        private $email;
        private $address;
        private $dob;
        private $doj;
        private $experience;
        private $qualification;

        public function __construct() {
            $this->database = new Database();
        }

        # Register Faculty
        public function register($post) {
            extract($post);

            // Clean Data
            $this->reg = htmlspecialchars(strip_tags($clgReg));
            $this->branchCode = htmlspecialchars(strip_tags($deptCode));
            $this->empid = htmlspecialchars(strip_tags($empId));
            $this->name = htmlspecialchars(strip_tags($empName));
            $this->contact = htmlspecialchars(strip_tags($empContact));
            $this->email = htmlspecialchars(strip_tags($empEmail));
            $this->address = htmlspecialchars(strip_tags($empAddress));
            $this->dob = htmlspecialchars(strip_tags($empDob));
            $this->doj = htmlspecialchars(strip_tags($empDoj));
            $this->experience = htmlspecialchars(strip_tags($empExperience));
            $this->qualification = htmlspecialchars(strip_tags($empQualification));

            // All sql commands
            $sql0 = 'SELECT * FROM faculties WHERE empid = :empid';
            $sql1 = 'INSERT INTO faculties SET empid = :empid, name = :name, contact = :contact, email = :email, address = :address, dob = :dob, doj = :doj, experience = :experience, qualification = :qualification';

            // Checking For Faculty's Existence
            $db = $this->reg . '_' . $this->branchCode;
            $conn = $this->database->connectSpec($db);
            $stmt = $conn->prepare($sql0);
            $stmt->bindParam(':empid', $this->empid);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }
            if ($stmt->rowCount() != 0) {
                return "Faculty already exist!";
            }

            // Inserting Data into Faculties Table under Department Database
            $stmt = $conn->prepare($sql1);
            $stmt->bindParam(':empid', $this->empid);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':contact', $this->contact);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':address', $this->address);
            $stmt->bindParam(':dob', $this->dob);
            $stmt->bindParam(':doj', $this->doj);
            $stmt->bindParam(':experience', $this->experience);
            $stmt->bindParam(':qualification', $this->qualification);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }
            return true;
        }

        # Faculty Names
        public function names($clgReg, $deptCode) {
            $this->reg = htmlspecialchars(strip_tags($clgReg));
            $this->branchCode = htmlspecialchars(strip_tags($deptCode));

            // SQL Command
            $sql0 = 'SELECT * FROM faculties';

            // Getting Names
            $db = $this->reg . '_' . $this->branchCode;
            $conn = $this->database->connectSpec($db);
            $stmt = $conn->prepare($sql0);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }
            if ($stmt->rowCount() == 0) {
                return false;
            }
            return $stmt->fetchAll();
        }

        # Faculty Info
        public function info ($clgReg, $deptCode, $empId) {
            // Clean Data
            $this->reg = htmlspecialchars(strip_tags($clgReg));
            $this->branchCode = htmlspecialchars(strip_tags($deptCode));
            $this->empid = htmlspecialchars(strip_tags($empId));

            // SQL Command
            $sql0 = 'SELECT * FROM faculties WHERE empid = :empid';

            // Getting Info
            $db = $this->reg . '_' . $this->branchCode;
            $conn = $this->database->connectSpec($db);
            $stmt = $conn->prepare($sql0);
            $stmt->bindParam(':empid', $this->empid);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }
            if ($stmt->rowCount() == 0) {
                return false;
            }
            return $stmt->fetchAll();
        }

        # Update Faculty Info
        public function update($post) {
            extract($post);

            // Clean Data
            $this->reg = htmlspecialchars(strip_tags($clgReg));
            $this->branchCode = htmlspecialchars(strip_tags($deptCode));
            $this->empid = htmlspecialchars(strip_tags($empId));
            $this->contact = htmlspecialchars(strip_tags($empContact));
            $this->email = htmlspecialchars(strip_tags($empEmail));
            $this->address = htmlspecialchars(strip_tags($empAddress));
            $this->experience = htmlspecialchars(strip_tags($empExperience));
            $this->qualification = htmlspecialchars(strip_tags($empQualification));

            // SQL Command
            $sql0 = 'UPDATE faculties SET contact = :contact, email = :email, address = :address, experience = :experience, qualification = :qualification WHERE empid = :empid';

            // Update Data into Faculties Table
            $db = $this->reg . '_' . $this->branchCode;
            $conn = $this->database->connectSpec($db);
            $stmt = $conn->prepare($sql0);
            $stmt->bindParam(':empid', $this->empid);
            $stmt->bindParam(':contact', $this->contact);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':address', $this->address);
            $stmt->bindParam(':experience', $this->experience);
            $stmt->bindParam(':qualification', $this->qualification);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }
            return true;
        }

        # Remove Faculty

    }