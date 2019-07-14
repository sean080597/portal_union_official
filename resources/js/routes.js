export const routes = [
    { path: '/', component: require('./components/Dashboard.vue').default },
    { path: '/developer', component: require('./components/Developer.vue').default },
    { path: '/users-admin', component: require('./components/UsersAdmin.vue').default },
    { path: '/faculties-admin', component: require('./components/FacultiesAdmin.vue').default },
    { path: '/classrooms-admin', component: require('./components/ClassRoomsAdmin.vue').default },
    { path: '/faculties', component: require('./components/FacultiesClient.vue').default },
    { path: '/classrooms/:faculty_id', component: require('./components/ClassRoomsClient.vue').default },
    { path: '/students/:classroom_id', component: require('./components/StudentsClient.vue').default },
    { path: '/student-profile/:student_id', component: require('./components/StudentProfileClient.vue').default },
    { path: '/students-admin', component: require('./components/StudentsAdmin.vue').default },
    { path: '/student-profile-admin', component: require('./components/StudentProfileAdmin.vue').default},
    { path: '/student-profile-admin/:id', component: require('./components/StudentProfileAdmin.vue').default, props:true },
    { path: '/evaluate-profile/:student_id', component: require('./components/EvaluateProfile.vue').default },
    { path: '/evaluate-faculty-dashboard/:faculty_id', component: require('./components/EvaluateFaculty_StatisticDashboard.vue').default },
    { path: '/evaluate-faculty-detail/:faculty_id', component: require('./components/EvaluateFaculty_StatisticDetail.vue').default },
    { path: '/evaluate-classroom-dashboard/:classroom_id', component: require('./components/EvaluateClassRoom_StatisticDashboard.vue').default },
    { path: '/evaluate-classroom-detail/:classroom_id', component: require('./components/EvaluateClassRoom_StatisticDetail.vue').default },

    // report
    { path: '/report-classroom/:classroom_id', component: require('./components/report/Report_Class.vue').default },
    { path: '/report-faculty/:fac_id', component: require('./components/report/Report_Faculty.vue').default },
    { path: '/report-school', component: require('./components/report/Report_School.vue').default },

    //mytask
    { path: '/mytask-classroom/:classroom_id', component: require('./components/mytask/task_class.vue').default },
    { path: '/mytask-faculty/:fac_id', component: require('./components/mytask/task_faculty.vue').default },
    { path: '/mytask-school', component: require('./components/mytask/task_school.vue').default },

    //chart
    { path: '/statistic', component: require('./components/Statistic.vue').default },

    { path: '*', component: require('./components/NotFound.vue').default },

    // ---------------- cam -------------------------

    //vue score board
    { path: '/bang-danh-gia/:student_id/:year', component: require('./components/ScoreBoard.vue').default},

    //event
    { path: '/create-event-score-board/', component: require('./components/EventStoreScoreBoards.vue').default},



];
