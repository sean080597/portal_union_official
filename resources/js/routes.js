export const routes = [
    { path: '/', component: require('./components/Dashboard.vue').default },
    { path: '/users-admin', component: require('./components/UsersAdmin.vue').default },
    { path: '/faculties-admin', component: require('./components/FacultiesAdmin.vue').default },
    { path: '/classrooms-admin', component: require('./components/ClassRoomsAdmin.vue').default },
    { path: '/faculties', component: require('./components/FacultiesClient.vue').default },
    { path: '/classrooms', component: require('./components/ClassRoomsClient.vue').default },
    { path: '/students', component: require('./components/StudentsClient.vue').default },
    { path: '/student-profile', component: require('./components/StudentProfileClient.vue').default },
];