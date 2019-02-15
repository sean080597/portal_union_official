export default {
    state: {
        welcomeMessage: 'Welcome to my vue App',
        student_info: {},
    },
    getters: {
        welcome(state){
            return state.welcomeMessage
        },
    },
    mutations: {
        FETCH_CUR_USER(state, payload){
            state.student_info = payload
        }
    },
    actions: {
        fetch_cur_user: async (context, user_id) => {
            let {data} = await axios.get('/api/getUserStudentInfoByUserId/' + user_id)
            context.commit('FETCH_CUR_USER', data)
        }
        // fetch_criteria: async (context, student_id) => {
        //     let {data} = await axios.get('/api/getMarkCriMan/' + student_id)
        //     context.commit('FETCH_CRIT_MAN', data)
        //     let res = await axios.get('/api/criteria_selfregis')
        //     context.commit('FETCH_CRIT_SEL', res.data)
        // }
    }
};