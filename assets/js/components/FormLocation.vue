<template>
  <div>
    <div class="overlay" v-if="loader">
      <div class="overlay__inner">
          <div class="overlay__content"><span class="spinner"></span></div>
      </div>
    </div>

    <div class="form-group">
      <label for="city">Enter City</label>
      <input type="text" class="form-control" id="city" v-model="city">
    </div>

    <div class="form-group">
      <label for="country">Enter country</label>
      <input type="text" class="form-control" id="country" v-model="country">
    </div>

    <button type="submit" class="btn btn-primary" @click="submit">Submit</button>

    <div v-if="results.location"> 
        <h2>Results</h2>
        <hr>
        <div class="row" v-for="(item, index) in results" :key="item.location">
            <div class="col-md-6">{{ index }}</div>
            <div class="col-md-6">{{ item }}</div>
        </div>
    </div>
    
    <div v-if="error"> 
        <h2>Error</h2>
        <hr>
        <div class="row"> {{ message}} </div>
    </div>
  </div>
</template>
<script>
  import axios from "axios";

  export default {
    name: "FormLocation",
    data() {
      return {
        city: "",
        country: "",
        loader: false,
        results: {},
        error:false,
        message: ''
      };
    },
    methods: {
      submit() {
        if (this.city != '' && this.country != '') {
          this.loader = true;
          
          axios.get('/api/weather/country/' + this.country + '/city/' + this.city)
            .then((response) => {
              if (response.data.status && response.data.status == 'error') 
              {
                this.error = true;
                this.message = response.data.message;
                this.results = {};
              } else {
                this.results  = response.data;
                this.error=false;
              }
              this.loader   = false;
            })
            .catch(function (error) {
              console.log(error);
            });
        }
      }
    }
  };
</script>