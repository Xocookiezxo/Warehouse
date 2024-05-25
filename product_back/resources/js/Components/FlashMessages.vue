<template>
  <div class="mx-8 mt-4">
    <div v-if="$page.props.flash.success && show" class="alert alert-success alert-dismissible  show justify-between">
      <strong><i class="ti-face-smile" /></strong> 
      <span class="flex-1"> {{ $page.props.flash.success }}</span>
      <button type="button" class="close" @click="show = false">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div v-if="$page.props.flash.warning && show" class="alert alert-warning alert-dismissible  show justify-between">
      <strong><i class="pe-7s-attention" /></strong> 
      <span class="flex-1"> {{ $page.props.flash.warning }}</span>
      <button type="button" class="close" @click="show = false">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div v-if="($page.props.flash.error || Object.keys($page.props.errors).length > 0) && show" class="alert alert-danger alert-dismissible  show justify-between">
      <strong>
        <strong><i class="ti-face-sad" /></strong>
      </strong>
      <span v-if="$page.props.flash.error" class="flex-1">
        {{ $page.props.flash.error }}
      </span>
   
      <button type="button" class="close" @click="show = false">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  </div>
</template>

<script>
import {useToast} from 'vue-toast-notification'
import 'vue-toast-notification/dist/theme-sugar.css'

export default {
  props:{
    errors:{type:Object,default:()=>({})},
  },
  data() {
    return {
      show: true,
      toast: useToast(),
    }
  },
  watch: {
    '$page.props.flash': {
      handler() {
        this.show = true
        if(this.$page.props.flash.success){
          let instance = this.toast.success(this.$page.props.flash.success,{ position: 'top-right'})
        }else if(this.$page.props.flash.warning){
          let instance = this.toast.warning(this.$page.props.flash.warning,{ position: 'top-right'})
        } else if(this.$page.props.flash.error){
          let instance = this.toast.error(this.$page.props.flash.error,{ position: 'top-right'})
        } 
      },
      deep: true,
    },
    '$page.props.errors': {
      handler(v) {
        if(Object.keys(v).length > 0){
          const this1=this
          Object.keys(v).forEach(function(k){
            this1.toast.error(v[k],{ position: 'top-right', pauseOnHover:true})
          })
          
        }
      },
      deep: true,
    },
  },
  mounted() {
    
    if(this.$page.props.flash.success){
      let instance = this.toast.success(this.$page.props.flash.success,{ position: 'top-right'})
    }else if(this.$page.props.flash.warning){
      let instance = this.toast.warning(this.$page.props.flash.warning,{ position: 'top-right'})
    } else if(this.$page.props.flash.error){
      let instance = this.toast.error(this.$page.props.flash.error,{ position: 'top-right'})
    } 
    
    
    
  },
}
</script>
