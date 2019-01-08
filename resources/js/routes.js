export const routes = [
    { path: '/', component: require('./components/Dashboard.vue').default },
    { path: '/faculties-admin', component: require('./components/FacultiesAdmin.vue').default },
    { path: '/faculties', component: require('./components/FacultiesClient.vue').default },
    { path: '/classrooms', component: require('./components/ClassRoomsClient.vue').default },
    { path: '/students', component: require('./components/StudentsClient.vue').default },
    { path: '/student-profile', component: require('./components/StudentProfileClient.vue').default },
];