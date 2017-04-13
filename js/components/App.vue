<template>
    <div>
      <div class="awesome_speech_bubble_list" v-for="item in box_list">
        <img :src="item.image_url" class="uploaded-thumbnail">
      </div>
      <input v-model="box_params.person_name" type="" name="" value="名前を入力">
      <select v-model="box_params.style_type" class="" name="">
        <option>LINE</option>
        <option>modern</option>
      </select>

      <button @click.prevent="clearInput">Show</button>
      <button @click.prevent="createProfile">Create</button>
      <button @click.prevent="openUploader">Choose photo</button>
      <span id="media"></span>
    </div>



</template>

<script>

    import Modal from './Modal.vue';

    export default {
      components: { 'asp-modal' : Modal },
      data () {
        return {
           message: 'test',
           box_params: {
              image_url: '',
              style_type: 'LINE',
              person_name: 'default',
           },
           box_list : {},
        }
      },
      computed: {

      },
      methods : {
        createProfile :function() {
          var params = Object.assign( this.box_params , awesome_speech_bubble_args)
          this.$http.get(awesome_speech_bubble_uri + '?action=awesome_speech_bubble', { params: params } ).then(response => {
            // get body data
            this.box_list = response.body;
            console.log(response.body)
            console.log(this.box_list)

          }, response => {
            // error callback
          });
        },
        displayImageThumbNail: function() {

        },

        clearInput: function() {
          this.box_params = {
            image_url: '',
            style_type: '',
            person_name: '',
          }
        },

        openUploader :function() {
          var custom_uploader
          var that = this
            if (custom_uploader) {
                custom_uploader.open();
                return;
            }
            custom_uploader = wp.media({
                title: 'Choose Image',
                library: {
                    type: 'image'
                },
                button: {
                    text: 'Choose Image'
                },
                multiple: false
            });

            custom_uploader.on('select', function() {
                var file = custom_uploader.state().get('selection').first().toJSON();
                (function($){
                  $('.uploaded-thumbnail').remove();
                  $('#media').append('<img class="uploaded-thumbnail" src="'+file.url+'" />');
               })(jQuery)
              that.box_params.image_url = file.url
            });
            custom_uploader.open();
        }
      },
      created: function() {
        var params = awesome_speech_bubble_args
        this.$http.get(awesome_speech_bubble_uri + '?action=awesome_speech_bubble&init=true', { params: params } ).then(response => {
          this.box_list = response.body;
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
