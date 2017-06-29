<template>
  <div>

    <button id="show-modal" @click="showModal = true">Show Modal</button>
    <!-- use the modal component, pass in the prop -->
    <modal v-if="showModal" @close="showModal = false">

        you can use custom content here to overwrite
        default content

      <h3 slot="header">custom header</h3>
    </modal>
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
    import Modal from './Modal.vue'
    export default {
      components: {
        Modal
      },
      data () {
        return {
            showModal: false,
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
        })
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
  .modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, .5);
  display: table;
  transition: opacity .3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 300px;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
  transition: all .3s ease;
  font-family: Helvetica, Arial, sans-serif;
}

.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}

.modal-body {
  margin: 20px 0;
}

.modal-default-button {
  float: right;
}

/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
</style>
