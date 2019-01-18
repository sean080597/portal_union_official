export const routes = [
    { path: '/', component: require('./components/Dashboard.vue').default },
    { path: '/users-admin', component: require('./components/UsersAdmin.vue').default },
    { path: '/faculties-admin', component: require('./components/FacultiesAdmin.vue').default },
    { path: '/classrooms-admin', component: require('./components/ClassRoomsAdmin.vue').default },
    { path: '/faculties', component: require('./components/FacultiesClient.vue').default },
    { path: '/classrooms/:faculty_id', component: require('./components/ClassRoomsClient.vue').default },
    { path: '/students/:classroom_id', component: require('./components/StudentsClient.vue').default },
    { path: '/student-profile/:student_id', component: require('./components/StudentProfileClient.vue').default },
    { path: '/students-admin', component: require('./components/StudentsAdmin.vue').default },
    { path: '/student-profile-admin/:student_id', component: require('./components/StudentProfileAdmin.vue').default },
];