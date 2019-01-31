export default class Gate{
    constructor(user, student, faculty){
        this.user = user;
        this.student = student;
        this.faculty = faculty
    }

    isAdmin(){
        return this.user.role_id === 'adm';
    }

    isAccSchool(){
        return this.user.role_id === 'sch';
    }

    isAccFaculty(){
        return this.user.role_id === 'fac';
    }

    isAccClass(){
        return this.user.role_id === 'cla';
    }

    isAccStudent(){
        return this.user.role_id === 'stu';
    }

    isAdminOrAccSchool(){
        return this.user.role_id === 'adm' || this.user.role_id === 'sch';
    }

    isClassroomPagePassed(){
        if(this.user.role_id === 'adm' || this.user.role_id === 'sch'){
            return true;
        }
        if(this.user.role_id === 'fac'){
            let curUrl = window.location.pathname;
            let faculty_id = curUrl.match(/([^\/]*)\/*$/)[1].toUpperCase();
            return faculty_id.includes(this.faculty.id);
        }
        return false;
    }

    isStudentsPagePassed(){
        if(this.user.role_id === 'adm' || this.user.role_id === 'sch'){
            return true;
        }
        if(this.user.role_id === 'fac'){
            let curUrl = window.location.pathname;
            let faculty_id = curUrl.match(/([^\/]*)\/*$/)[1].toUpperCase();
            return faculty_id.includes(this.faculty.id);
        }
        if(this.user.role_id === 'cla'){
            let curUrl = window.location.pathname;
            let classroom_id = curUrl.match(/([^\/]*)\/*$/)[1].toUpperCase();
            return classroom_id.includes(this.student.class_room_id);
        }
        return false;
    }

    isStudentProfilePagePassed(cla_id){
        if(this.user.role_id === 'adm' || this.user.role_id === 'sch'){
            return true;
        }
        if(this.user.role_id === 'fac'){
            return cla_id.includes(this.faculty.id);
        }
        if(this.user.role_id === 'cla'){
            return cla_id.includes(this.student.class_room_id);
        }
        if(this.user.role_id === 'stu'){
            let curUrl = window.location.pathname;
            let student_id = curUrl.match(/([^\/]*)\/*$/)[1];
            return student_id.includes(this.student.id);
        }
        return false;
    }

    showRoleId(){
        let curUrl = window.location.pathname;
        let faculty_id = curUrl.match(/([^\/]*)\/*$/)[1].toUpperCase();
        return faculty_id.includes(this.faculty.id);
    }
}