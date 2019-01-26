export default class Gate{
    constructor(user){
        this.user = user;
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

    isAccStudent(){
        return this.user.role_id === 'stu';
    }
}