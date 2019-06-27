<template>
  <div class="row">
    <div class="col-xs-12 col-sm-8 col-md-4">
      <div class="input-group">
        <select
          name="state"
          id="maxRows"
          class="form-control"
          v-model="selected"
          @change="getStatistic(selected)"
        >
          <option v-for="(item) in selYear" :key="item.year" :value="item.year">{{item.year}}</option>
        </select>
      </div>
    </div>
    <div class="col-xs-12 col-sm-10">
      <apexcharts type="line" height="300" :options="chartOptions" :series="series"></apexcharts>
    </div>
  </div>
</template>
<script>
import VueApexCharts from "vue-apexcharts";
export default {
  name: "LineChart",
  components: {
    apexcharts: VueApexCharts
  },
  data: function() {
    return {
      chartOptions: {
        xaxis: {
          title: {
            text: "ĐIỂM TB",
            offsetX: 0,
            offsetY: 0,
            style: {
              color: "#78909C",
              fontSize: "inherit",
              fontFamily: "Helvetica, Arial, sans-serif",
              cssClass: "apexcharts-xaxis-title"
            }
          }
        },
        yaxis: {
          opposite: true,
          axisBorder: {
            show: true,
            color: "#78909C",
            offsetX: 0,
            offsetY: 0
          },
          title: {
            text: "SỐ LƯỢNG SV",
            offsetX: 0,
            offsetY: 0,
            style: {
              color: "#78909C",
              fontSize: "16px",
              fontFamily: "Helvetica, Arial, sans-serif",
              cssClass: "apexcharts-xaxis-title"
            }
          },
          labels: {
            // formatter: function(val, index) {
            //   return val.toFixed(0);
            // }
          }
        },
        chart: {
          zoom: {
            enabled: false
          },
          animations: {
            enabled: false
          }
        },
        stroke: {
          width: [5, 5, 4],
          curve: "straight"
        }
      },
      series: [],
      selYear: [],
      selected: new Date().getFullYear()
    };
  },

  methods: {
    getSelectYear() {
      axios.get("/api/getAllAvgScoreYear").then(({ data }) => {
        this.selYear = data;
      });
    },
    getStatistic(year) {
      this.$Progress.start();
      axios.get("/api/getStatisticScoreBoard/" + year).then(({ data }) => {
        this.chartOptions = {
          ...this.chartOptions,
          ...{
            xaxis: {
              categories: data.averageScore
            }
          }
        };
        this.series = [data.statistic];
        this.$Progress.finish();
      });
    }
  },

  created() {
    this.getSelectYear();
    this.getStatistic(new Date().getFullYear());
  },

  mounted() {
    //   console.log(this.chartOptions.xaxis.categories)
  },

  updated() {}
};
</script>
