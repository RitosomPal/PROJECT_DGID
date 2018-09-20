<?php
    include_once('./config/Database.php');

    class Student {
        // Class Variable
        private $database;

        // Student Basic Info
        private $reg;
        private $branchCode;
        private $sem;
        private $year;
        private $uid;

        // Student Personal Info
        private $name;
        private $dob;
        private $gender;
        private $contact;
        private $email;
        private $present_address;
        private $district;
        private $blood_grp;
        private $birth_mark;
        private $birth_place;
        private $physically_challenged;
        private $caste;
        private $religion;
        private $aadhar;
        private $kanyashree;

        // Student Madhyamik Info
        private $mdk_scl_name;
        private $mdk_scl_district;
        private $mdk_board_name;
        private $mdk_passing_year;
        private $mdk_reg_no;
        private $mdk_roll;
        private $mdk_no;
        private $mdk_physics_marks;
        private $mdk_maths_marks;
        private $mdk_aggreagate_marks;
        private $mdk_full_marks;
        private $mdk_percent;
        private $mdk_division;

        // Student HS Info
        private $hs_scl_name;
        private $hs_scl_district;
        private $hs_board_name;
        private $hs_passing_year;
        private $hs_reg_no;
        private $hs_roll;
        private $hs_no;
        private $hs_aggreagate_marks;
        private $hs_full_marks;
        private $hs_percent;
        private $hs_division;

        // Student Guardians Info
        private $father_name;
        private $mother_name;
        private $guardian_non_parent;
        private $guardian_non_parent_relation;
        private $guardian_contact;
        private $guardian_email;
        private $guardian_present_address;
        private $guardian_permanent_address;
        private $guardian_occupation;
        

        public function __construct($clgReg) {
            $this->database = new Database();
            $this->reg = htmlspecialchars(strip_tags($clgReg));
        }

        # Register Student

        // Basic Info
        public function register_basic($post) {
            extract($post);

            // Clean Data
            $this->branchCode = htmlspecialchars(strip_tags($deptCode));
            $this->branchCodeFY = htmlspecialchars(strip_tags($deptCodeFY));
            $this->sem = htmlspecialchars(strip_tags($stdSem));
            $this->year = htmlspecialchars(strip_tags($stdYear));
            $this->uid = htmlspecialchars(strip_tags($stdUid));

            // Sql Commands
            $sql0 = 'SELECT * FROM students WHERE uid = :uid';
            $sql1 = 'INSERT INTO students SET sem = :sem, year = :year, uid = :uid';

            // Checking For Student's Existence
            $db = $this->reg . '_' . $this->branchCode;
            $conn = $this->database->connectSpec($db);
            $stmt = $conn->prepare($sql0);
            $stmt->bindParam(':uid', $this->uid);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }
            if ($stmt->rowCount() != 0) {
                return "Student already exist!";
            }

            // Inserting Data into Students Table
            $stmt = $conn->prepare($sql1);
            $stmt->bindParam(':sem', $this->sem);
            $stmt->bindParam(':year', $this->year);
            $stmt->bindParam(':uid', $this->uid);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }
            return true;
        }

        // Personal Details
        public function update_personal($post) {
            extract($post);

            // Clean Data
            $this->branchCode = htmlspecialchars(strip_tags($deptCode));
            $this->uid = htmlspecialchars(strip_tags($stdUid));
            $this->name = htmlspecialchars(strip_tags($stdName));
            $this->dob = htmlspecialchars(strip_tags($stdDob));
            $this->gender = htmlspecialchars(strip_tags($stdGender));
            $this->contact = htmlspecialchars(strip_tags($stdContact));
            $this->email = htmlspecialchars(strip_tags($stdEmail));
            $this->present_address = htmlspecialchars(strip_tags($stdPresent_address));
            $this->district = htmlspecialchars(strip_tags($stdDistrict));
            $this->blood_grp = htmlspecialchars(strip_tags($stdBlood_grp));
            $this->birth_mark = htmlspecialchars(strip_tags($stdBirth_mark));
            $this->birth_place = htmlspecialchars(strip_tags($stdBirth_place));
            $this->physically_challenged = htmlspecialchars(strip_tags($stdPhysically_challenged));
            $this->caste = htmlspecialchars(strip_tags($stdCaste));
            $this->religion = htmlspecialchars(strip_tags($stdReligion));
            $this->aadhar = htmlspecialchars(strip_tags($stdAadhar));
            $this->kanyashree = htmlspecialchars(strip_tags($stdKanyashree));

            // Sql command
            $sql0 = 'UPDATE students SET name = :name, dob = :dob, gender = :gender, contact = :contact, email = :email, present_address = :present_address, district = :district, blood_group = :blood_grp, birth_mark = :birth_mark, birth_place = :birth_place, physically_challenged = :physically_challenged, caste = :caste, religion = :religion, aadhar = :aadhar, kanyashree = :kanyashree WHERE uid = :uid';

            // Update Data into Students Table
            $db = $this->reg . '_' . $this->branchCode;
            $conn = $this->database->connectSpec($db);
            $stmt = $conn->prepare($sql0);
            $stmt->bindParam(':uid', $this->uid);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':dob', $this->dob);
            $stmt->bindParam(':gender', $this->gender);
            $stmt->bindParam(':contact', $this->contact);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':present_address', $this->present_address);
            $stmt->bindParam(':district', $this->district);
            $stmt->bindParam(':blood_grp', $this->blood_grp);
            $stmt->bindParam(':birth_mark', $this->birth_mark);
            $stmt->bindParam(':birth_place', $this->birth_place);
            $stmt->bindParam(':physically_challenged', $this->physically_challenged);
            $stmt->bindParam(':caste', $this->caste);
            $stmt->bindParam(':religion', $this->religion);
            $stmt->bindParam(':aadhar', $this->aadhar);
            $stmt->bindParam(':kanyashree', $this->kanyashree);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }
            return true;
        }

        // Madhyamik Info
        public function update_madhyamik($post) {
            extract($post);

            // Clear Data
            $this->branchCode = htmlspecialchars(strip_tags($deptCode));
            $this->uid = htmlspecialchars(strip_tags($stdUid));
            $this->mdk_scl_name = htmlspecialchars(strip_tags($stdMdk_scl_name));
            $this->mdk_scl_district = htmlspecialchars(strip_tags($stdMdk_scl_district));
            $this->mdk_board_name = htmlspecialchars(strip_tags($stdMdk_board_name));
            $this->mdk_passing_year = htmlspecialchars(strip_tags($stdMdk_passing_year));
            $this->mdk_reg_no = htmlspecialchars(strip_tags($stdMdk_reg_no));
            $this->mdk_roll = htmlspecialchars(strip_tags($stdMdk_roll));
            $this->mdk_no = htmlspecialchars(strip_tags($stdMdk_no));
            $this->mdk_physics_marks = htmlspecialchars(strip_tags($stdMdk_physics_marks));
            $this->mdk_maths_marks = htmlspecialchars(strip_tags($stdMdk_maths_marks));
            $this->mdk_aggreagate_marks = htmlspecialchars(strip_tags($stdMdk_aggreagate_marks));
            $this->mdk_full_marks = htmlspecialchars(strip_tags($stdMdk_full_marks));
            $this->mdk_percent = htmlspecialchars(strip_tags($stdMdk_percent));
            $this->mdk_division = htmlspecialchars(strip_tags($stdMdk_division));


            // sql Commands
            $sql0 = 'UPDATE students SET mdk_scl_name = :mdk_scl_name, mdk_scl_district = :mdk_scl_district, mdk_board_name = :mdk_board_name, mdk_passing_year = :mdk_passing_year, mdk_reg_no = :mdk_reg_no, mdk_roll = :mdk_roll, mdk_no = :mdk_no, mdk_physics_marks = :mdk_physics_marks, mdk_maths_marks = :mdk_maths_marks, mdk_aggreagate_marks = :mdk_aggreagate_marks, mdk_full_marks = :mdk_full_marks, mdk_percent = :mdk_percent, mdk_division = :mdk_division WHERE uid= :uid';

            // Update Data into Students Table
            $db = $this->reg . '_' . $this->branchCode;
            $conn = $this->database->connectSpec($db);
            $stmt = $conn->prepare($sql0);
            $stmt->bindParam(':uid', $this->uid);
            $stmt->bindParam(':mdk_scl_name', $this->mdk_scl_name);
            $stmt->bindParam(':mdk_scl_district', $this->mdk_scl_district);
            $stmt->bindParam(':mdk_board_name', $this->mdk_board_name);
            $stmt->bindParam(':mdk_passing_year', $this->mdk_passing_year);
            $stmt->bindParam(':mdk_reg_no', $this->mdk_reg_no);
            $stmt->bindParam(':mdk_roll', $this->mdk_roll);
            $stmt->bindParam(':mdk_no', $this->mdk_no);
            $stmt->bindParam(':mdk_physics_marks', $this->mdk_physics_marks);
            $stmt->bindParam(':mdk_maths_marks', $this->mdk_maths_marks);
            $stmt->bindParam(':mdk_aggreagate_marks', $this->mdk_aggreagate_marks);
            $stmt->bindParam(':mdk_full_marks', $this->mdk_full_marks);
            $stmt->bindParam(':mdk_percent', $this->mdk_percent);
            $stmt->bindParam(':mdk_division', $this->mdk_division);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }
            return true;
        }

        // HS Info
        public function update_hs($post) {
            extract($post);

            // Clear Data
            $this->branchCode = htmlspecialchars(strip_tags($deptCode));
            $this->uid = htmlspecialchars(strip_tags($stdUid));
            $this->hs_scl_name = htmlspecialchars(strip_tags($stdHs_scl_name));
            $this->hs_scl_district = htmlspecialchars(strip_tags($stdHs_scl_district));
            $this->hs_board_name = htmlspecialchars(strip_tags($stdHs_board_name));
            $this->hs_passing_year = htmlspecialchars(strip_tags($stdHs_passing_year));
            $this->hs_reg_no = htmlspecialchars(strip_tags($stdHs_reg_no));
            $this->hs_roll = htmlspecialchars(strip_tags($stdHs_roll));
            $this->hs_no = htmlspecialchars(strip_tags($stdHs_no));
            $this->hs_aggreagate_marks = htmlspecialchars(strip_tags($stdHs_aggreagate_marks));
            $this->hs_full_marks = htmlspecialchars(strip_tags($stdHs_full_marks));
            $this->hs_percent = htmlspecialchars(strip_tags($stdHs_percent));
            $this->hs_division = htmlspecialchars(strip_tags($stdHs_division));


            // sql Commands
            $sql0 = 'UPDATE students SET hs_scl_name = :hs_scl_name, hs_scl_district = :hs_scl_district, hs_board_name = :hs_board_name, hs_passing_year = :hs_passing_year, hs_reg_no = :hs_reg_no, hs_roll = :hs_roll, hs_no = :hs_no, hs_aggreagate_marks = :hs_aggreagate_marks, hs_full_marks = :hs_full_marks, hs_percent = :hs_percent, hs_division = :hs_division WHERE uid= :uid';
            
            // Update Data into Students Table
            $db = $this->reg . '_' . $this->branchCode;
            $conn = $this->database->connectSpec($db);
            $stmt = $conn->prepare($sql0);
            $stmt->bindParam(':uid', $this->uid);
            $stmt->bindParam(':hs_scl_name', $this->hs_scl_name);
            $stmt->bindParam(':hs_scl_district', $this->hs_scl_district);
            $stmt->bindParam(':hs_board_name', $this->hs_board_name);
            $stmt->bindParam(':hs_passing_year', $this->hs_passing_year);
            $stmt->bindParam(':hs_reg_no', $this->hs_reg_no);
            $stmt->bindParam(':hs_roll', $this->hs_roll);
            $stmt->bindParam(':hs_no', $this->hs_no);
            $stmt->bindParam(':hs_aggreagate_marks', $this->hs_aggreagate_marks);
            $stmt->bindParam(':hs_full_marks', $this->hs_full_marks);
            $stmt->bindParam(':hs_percent', $this->hs_percent);
            $stmt->bindParam(':hs_division', $this->hs_division);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }
            return true;
        }

        // Guardians Info
        public function update_guardians($post) {
            extract($post);

            // CLear Data
            $this->branchCode = htmlspecialchars(strip_tags($deptCode));
            $this->uid = htmlspecialchars(strip_tags($stdUid));
            $this->father_name = htmlspecialchars(strip_tags($stdFather_name));
            $this->mother_name = htmlspecialchars(strip_tags($stdMother_name));
            $this->guardian_non_parent = htmlspecialchars(strip_tags($stdGuardian_non_parent));
            $this->guardian_non_parent_relation = htmlspecialchars(strip_tags($stdGuardian_non_parent_relation));
            $this->guardian_contact = htmlspecialchars(strip_tags($stdGuardian_contact));
            $this->guardian_email = htmlspecialchars(strip_tags($stdGuardian_email));
            $this->guardian_present_address = htmlspecialchars(strip_tags($stdGuardian_present_address));
            $this->guardian_permanent_address = htmlspecialchars(strip_tags($stdGuardian_permanent_address));
            $this->guardian_occupation = htmlspecialchars(strip_tags($stdGuardian_occupation));

            // sql Commands
            $sql0 = 'UPDATE students SET father_name = :father_name,mother_name = :mother_name, guardian_non_parent = :guardian_non_parent, guardian_non_parent_relation = :guardian_non_parent_relation, guardian_contact = :guardian_contact, guardian_email = :guardian_email, guardian_present_address = :guardian_present_address,guardian_permanent_address = :guardian_permanent_address, guardian_occupation = :guardian_occupation WHERE uid= :uid';
            
            // Update Data into Students Table
            $db = $this->reg . '_' . $this->branchCode;
            $conn = $this->database->connectSpec($db);
            $stmt = $conn->prepare($sql0);
            $stmt->bindParam(':uid', $this->uid);
            $stmt->bindParam(':father_name', $this->father_name);
            $stmt->bindParam(':mother_name', $this->mother_name);
            $stmt->bindParam(':guardian_non_parent', $this->guardian_non_parent);
            $stmt->bindParam(':guardian_non_parent_relation', $this->guardian_non_parent_relation);
            $stmt->bindParam(':guardian_contact', $this->guardian_contact);
            $stmt->bindParam(':guardian_email', $this->guardian_email);
            $stmt->bindParam(':guardian_present_address', $this->guardian_present_address);
            $stmt->bindParam(':guardian_permanent_address', $this->guardian_permanent_address);
            $stmt->bindParam(':guardian_occupation', $this->guardian_occupation);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }
            return true;
        }

        # Student Names
        public function names($deptCode) {

            $this->branchCode = htmlspecialchars(strip_tags($deptCode));

            // SQL Command
            $sql0 = 'SELECT * FROM students';

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

        # Student Info
        public function info ($deptCode, $uid) {
            // Clean Data
            $this->branchCode = htmlspecialchars(strip_tags($deptCode));
            $this->uid = htmlspecialchars(strip_tags($uid));

            // SQL Command
            $sql0 = 'SELECT * FROM students WHERE uid = :uid';

            // Getting Info
            $db = $this->reg . '_' . $this->branchCode;
            $conn = $this->database->connectSpec($db);
            $stmt = $conn->prepare($sql0);
            $stmt->bindParam(':uid', $this->uid);
            if ($stmt->execute()) {} else {
                return $stmt->error;
            }
            if ($stmt->rowCount() == 0) {
                return false;
            }
            return $stmt->fetchAll();
        }

        # Remove Student 

    }