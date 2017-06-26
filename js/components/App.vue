<template>
  <div>
    <select v-model=selectedUser>
      <option disabled value="0">
        Select User
      </option>
      <option v-for="(value, key) in asp_params" :value="value.id">
        {{value.name}}
      </option>
    </select>
    <select v-model=selectedPosition>
      <option v-for="value in positions" :value="value.position">
        {{value.position}}
      </option>
    </select>
    <select v-model=selectedSize>
      <option v-for="size in sizes" :value="size.value">
        {{size.type}}
      </option>
    </select>
    <textarea v-model="message" placeholder="enter text"></textarea>
    <button type="button" name="button" @click="insertShortCode">insert</button>
  </div>
</template>

<script>

    import Modal from './Modal.vue';

    export default {
      data () {
        return {
            message: '',
            selectedUser : '',
            selectedPosition : 'left',
            selectedSize: 'small',
            positions : [
                { position: 'left' },
                { position: 'right' }
            ],
            sizes: [
                { type: 'small', value: 32 },
                { type: 'medium', value: 50 },
                { type: 'large', value: 100 }
            ],
            asp_params : {},
        }
      },
      computed: {

      },
      methods : {
        insertShortCode : function() {
            send_to_editor( '[asp_sc id="' + this.selectedUser + '" message="' + this.message +'" pos="' + this.selectedPosition + '" size="' + this.selectedSize + '"]' )
        },
        showEditWindow : function() {
        },
      },
      created: function() {
        var params = awesome_speech_bubble_args
        this.$http.get(awesome_speech_bubble_uri + '?action=awesome_speech_bubble&init=true', { params: params } ).then(response => {
          this.asp_params = response.body;
        }, response => {
          // error callback
        });
      }
    }

</script>

<style>
  #app {
    font-family: 'Avenir', Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    color: #2c3e50;
  }
  .uploaded-thumbnail {
    max-width: 100%;
    width: 120px;
    height: 120px;
  }
</style>
