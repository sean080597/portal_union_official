export default {
    state: {
        welcomeMessage: 'Welcome to my vue App',
        student_info: {},
        ls_cri_mand: {},
        ls_cri_self: {},
    },
    getters: {
        welcome(state){
            return state.welcomeMessage
        },
        getMarkCriMan(state){
            return state.ls_cri_mand
        },
        getMarkCriSel(state){
            return state.ls_cri_self
        }
    },
    mutations: {
        FETCH_CUR_USER(state, payload){
            state.student_info = payload
        },
        FETCH_CRIT_MAN(state, payload){
            state.ls_cri_mand = payload
        },
        FETCH_CRIT_SEL(state, payload){
            state.ls_cri_self = payload
        }
    },
    actions: {
        fetch_cur_user: async (context, user_id) => {
            let {data} = await axios.get('/api/getUserStudentInfoByUserId/' + user_id)
            context.commit('FETCH_CUR_USER', data)
        },
        fetch_criteria: async (context) => {
            let {data} = await axios.get('/api/criteria_mandatory')
            context.commit('FETCH_CRIT_MAN', data)
            let res = await axios.get('/api/criteria_selfregis')
            context.commit('FETCH_CRIT_SEL', res.data)
        }
        // fetch_criteria: async (context, student_id) => {
        //     let {data} = await axios.get('/api/getMarkCriMan/' + student_id)
        //     context.commit('FETCH_CRIT_MAN', data)
        //     let res = await axios.get('/api/criteria_selfregis')
        //     context.commit('FETCH_CRIT_SEL', res.data)
        // }
    }
};