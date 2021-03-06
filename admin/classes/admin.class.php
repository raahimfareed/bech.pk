<?php
include_once('dbh.class.php');

Class Admin extends Dbh {
    protected $first_name;
    protected $last_name;
    protected $email;
    protected $profile_image;
    protected $permission_level;
    protected $registration_date;

    public function AddAdmin ($first_name, $last_name, $email, $password, $date) {
        $user_id = md5(uniqid('', true));
        $sql = "SELECT * from users where `UserId` = ?";
        $stmt = $this -> GetDB() -> prepare($sql);
        if ($stmt -> execute([$user_id])) {
            while ($stmt -> rowCount() > 0) {
                $user_id = md5(uniqid('', true));
            }
        }
        
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $rand = mt_rand(1, 16); // Random number in between 1 and 16
        
        switch ($rand) {
            case 1:
                $profile_pic = "assets/images/profile-pics/defaults/head_alizarin.png";
                break;
                case 2:
                $profile_pic = "assets/images/profile-pics/defaults/head_amethyst.png";
            break;
            case 3:
                $profile_pic = "assets/img/profile-pics/defaults/head_belize_hole.png";
            break;
            case 4:
                $profile_pic = "assets/img/profile-pics/defaults/head_carrot.png";
            break;
            case 5:
                $profile_pic = "assets/img/profile-pics/defaults/head_deep_blue.png";
            break;
            case 6:
                $profile_pic = "assets/img/profile-pics/defaults/head_emerald.png";
            break;
            case 7:
                $profile_pic = "assets/img/profile-pics/defaults/head_green_sea.png";
            break;
            case 8:
                $profile_pic = "assets/img/profile-pics/defaults/head_nephritis.png";
            break;
            case 9:
                $profile_pic = "assets/img/profile-pics/defaults/head_pete_river.png";
            break;
            case 10:
                $profile_pic = "assets/img/profile-pics/defaults/head_pomegranate.png";
            break;
            case 11:
                $profile_pic = "assets/img/profile-pics/defaults/head_pumpkin.png";
                break;
            case 12:
                $profile_pic = "assets/img/profile-pics/defaults/head_red.png";
                break;
                case 13:
                $profile_pic = "assets/img/profile-pics/defaults/head_sun_flower.png";
            break;
            case 14:
                $profile_pic = "assets/img/profile-pics/defaults/head_turqoise.png";
            break;
            case 15:
                $profile_pic = "assets/img/profile-pics/defaults/head_wet_asphalt.png";
                break;
                case 16:
                $profile_pic = "assets/img/profile-pics/defaults/head_wisteria.png";
            break;
            default:
            $profile_pic = "assets/img/profile-pics/defaults/head_wet_asphalt.png";
        break;
        }
        
        $sql = "INSERT into users (`UserId`, `FirstName`, `LastName`, `Email`, `Password`, `ProfileImage`, `RegistrationDate`) values (?, ?, ?, ?, ?, ?, ?);";
        $stmt = $this -> GetDB() -> prepare($sql);
        if ($stmt -> execute([$user_id, $first_name, $last_name, $email, $hashed_password, $profile_pic, $date])) {
            return true;
        }
    }

    public function CheckAdmin($email) {
        $sql = "SELECT * from admins where `Email` = ?";
        $stmt = $this -> GetDB() -> prepare($sql);
        $stmt -> execute([$email]);
        if ($stmt -> rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function VerifyAdmin($email, $password) {
        $sql = "SELECT * from admins where Email = ?";
        $stmt = $this -> GetDB() -> prepare($sql);
        
        $stmt -> execute([$email]);
        
        if ($stmt -> rowCount() > 0) {
            $row = $stmt -> fetch();
            
            if (password_verify($password, $row['Password'])) return true;
            else return false;
        }
    }

    public function GetAdminId($email) {
        $sql = "SELECT * from admins where Email = ?";
        $stmt = $this -> GetDB() -> prepare($sql);
        $stmt -> execute([$email]);
        $row = $stmt -> fetch();
        $this -> admin_id = $row['AdminId'];
        return $this -> admin_id;
    }

    public function GetInfo($admin_id) {
        $sql = "SELECT * from admins where AdminId = ?";
        $stmt = $this -> GetDB() -> prepare($sql);
        $stmt -> execute([$admin_id]);
        if ($stmt -> rowCount() != 1) {
            return false;
        } else {
            $row = $stmt -> fetch();
            $this -> first_name = $row['FirstName'];
            $this -> last_name = $row['LastName'];
            $this -> email = $row['Email'];
            $this -> profile_image = $row['ProfileImage'];
            $this -> permission_level = $row['PermissionLevel'];
            $reg_date = new DateTime($row['RegistrationDate']);
            $this -> registration_date = $reg_date -> format("d-M-Y");
            return true;
        }
    }

    public function GetFirstName() {
        return $this -> first_name;
    }
    public function GetLastName() {
        return $this -> last_name;
    }
    public function GetEmail() {
        return $this -> email;
    }
    public function GetProfileImage() {
        return $this -> profile_image;
    }
    public function GetPermissionLevel() {
        return $this -> permission_level;
    }
    public function GetRegistrationDate() {
        return $this -> registration_date;
    }

    public function GetAdminsNum() {
        $sql = "SELECT * from admins";
        $stmt = $this -> GetDB() -> prepare($sql);
        $stmt -> execute();
        return $stmt -> rowCount();
    }

}