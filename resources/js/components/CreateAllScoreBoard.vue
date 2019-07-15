<template>
    <div>
        <div class="form-group">
            <h1 class="text-primary">Tiến Trình</h1>
            <div class="progress">
                <div class="progress-bar text-danger" :style="getPercent">{{getWidth}}%</div>
            </div>
            <div class="text-center"><small>{{getCurrent}}/{{getTotal}}</small></div>
        </div>
        <div class="form-group">
            <button class="btn btn-success" @click="insertListScoreboard()" v-if="isStart" :disabled="isDisabled">Bắt đầu</button>
            <button class="btn btn-primary" @click="insertListScoreboard()" v-if="isContinute" :disabled="isDisabled">Tiếp tục</button>
            <h5 class="text-danger" v-if="isSuccess">Thành công</h5>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        currentYear:{
            type : String,
            require: true
        }
    },
    data() {
        return {
            width: 0,
            total:1,
            current: 0,
            isRun: false,
            listStudentId: []
        }
    },
    computed: {
        getWidth(){
            this.width = (this.current*100)/this.total
            let width = this.width
            return width.toFixed(1)
        },
        getPercent(){
            return 'width:' + this.getWidth + '%'
        },
        getTotal(){
            return this.total
        },
        getCurrent(){
            return this.current
        },
        isStart(){
            if(parseInt(this.current) == 0){
                return true
            }
            return false
        },
        isContinute(){
            if(!this.isStart && !this.isSuccess){
                return true
            }
            return false
        },
        isSuccess(){
            if(parseInt(this.current) == parseInt(this.total)){
                return true
            }
            return false
        },
        isRunning(){
            return this.isRun
        },
        isDisabled(){
            if(this.isRunning || this.isSuccess){
                return true
            }
            return false
        }
        
    },
    watch: {
        currentYear:function(){
            this.getCurrentScoreboard(this.currentYear)
            this.getMissCurrentScoreboard(this.currentYear)
        }
    },
    created() {
        this.getTotalStudent()
    },
    methods: {
        getTotalStudent(){
            axios.get('/api/getTotalStudent')
            .then((data) => {
                this.total = data.data.result
            })    
        },
        getCurrentScoreboard(year){
            axios.get('/api/getCurrentScoreboard/'+year)
            .then((data) => {
                this.current = data.data[0].result
            })
        },
        getMissCurrentScoreboard(year){
            axios.get('/api/getMissCurrentScoreboard/' + year)
            .then((data) => {
                this.listStudentId = data.data
            })
        },
        async insertListScoreboard(){
            this.isRun = true
            let count = 0
            for(let student of this.listStudentId){
                setTimeout(function(){console.log(++count)},2000)
                const {data} = await axios.get('/api/createEvaluationEvent/' + student.id + '/' + this.currentYear)
                this.current++
            }
        }
    },
}
</script>