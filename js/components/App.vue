<template>
  <div>

    <button class="button" id="show-modal" @click.prevent="showModal = true">Add Speech Bubble</button>
    <!-- use the modal component, pass in the prop -->
    <modal v-if="showModal" @close="showModal = false">
      <h3 slot="header"> Please Add your Speech Bubble</h3>
    </modal>
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
        }
      },
      computed: {
      },
      methods : {
        insertShortCode : function() {
            send_to_editor( '[asp_sc id="' + this.selectedUser + '" message="' + this.message +'" pos="' + this.selectedPosition + '" size="' + this.selectedSize + '"]' )
        },
      }
    }

</script>

<style lang="stylus">
#app
    font-family 'Avenir', Helvetica, Arial, sans-serif
    -webkit-font-smoothing antialiased
    -moz-osx-font-smoothing grayscale
    color #2c3e50

.modal-mask
    position fixed
    z-index 9998
    top 0
    left 0
    width 100%
    height 100%
    background-color rgba(0, 0, 0, .5)
    display table
    transition opacity .3s ease

.modal-wrapper
    display table-cell
    vertical-align middle

.modal-container
    width 80%
    height 500px
    margin 0px auto
    padding 20px
    background-color #fff
    border-radius 2px
    box-shadow 0 2px 8px rgba(0, 0, 0, .33)
    transition all .3s ease
    font-family Helvetica, Arial, sans-serif
    @media screen and (min-width: 600px)
      width: 50%
    .button
      margin 10px

.modal-header
    h3
        margin-top 0
        color #1e2220

.modal-body
    margin 20px 0
    strong
      display block

.modal-default-button
    float left

.modal-enter
    opacity 0

.modal-leave-active
    opacity 0

.modal-enter .modal-container,
.modal-leave-active .modal-container
    -webkit-transform scale(1.1)
    transform scale(1.1)
</style>
