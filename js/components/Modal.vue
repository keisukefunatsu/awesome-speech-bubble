<template>
    <transition name="modal">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-container">

            <div class="modal-header">
              <slot name="header">
                Please Add your Speech Bubble
              </slot>
            </div>
            <hr>
            <div class="modal-body">
              <slot name="body">
                <p>
                  <strong>Username</strong>
                  <select v-model=selectedUser>
                    <option v-for="(value, key) in asb_params" :value="value.id">
                      {{value.name}}
                    </option>
                  </select>
                </p>
              </slot>
            </div>
            <div class="modal-body">
              <slot name="body">
                <p>
                  <strong>Position</strong>
                  <select v-model=selectedPosition>
                    <option v-for="position in positions" :value="position.type">
                      {{position.type}}
                    </option>
                  </select>
                </p>
              </slot>
            </div>
            <div class="modal-body">
              <slot name="body">
                <p>
                  <strong>Size</strong>
                  <select v-model=selectedSize>
                    <option v-for="size in sizes" :value="size.value">
                      {{size.type}}
                    </option>
                  </select>
                </p>
              </slot>
            </div>
            <div class="modal-body">
              <slot name="body">
                <p>
                  <strong>Text</strong>
                  <textarea v-model="message" placeholder="enter text"></textarea>
                </p>
              </slot>
            </div>

            <div class="modal-footer">
              <slot name="footer">
                <hr>
                <button class="modal-default-button button" href="#" @click.prevent="$emit('close') + insertShortCode()">
                  Insert
                </button>
                <button class="modal-default-button button" href="#" @click.prevent="$emit('close')">
                  Cancel
                </button>
              </slot>
            </div>
          </div>
        </div>
      </div>
    </transition>
</template>

<script>
    export default {
      data () {
        return {
            message: '',
            selectedUser : '',
            selectedPosition : '',
            selectedSize: '',
            positions : [
                { type: 'left' },
                { type: 'right' }
            ],
            sizes: [
                { type: 'small', value: 32 },
                { type: 'medium', value: 50 },
                { type: 'large', value: 100 }
            ],
            asb_params : {},
        }
      },
      methods : {
        insertShortCode : function() {
            send_to_editor( '[asb_sc id="' + this.selectedUser + '" message="' + this.message +'" pos="' + this.selectedPosition + '" size="' + this.selectedSize + '"]' )
        },
      },
      created: function() {
        var params = awesome_speech_bubble_args
        this.$http.get(awesome_speech_bubble_uri + '?action=awesome_speech_bubble&init=true', { params: params } ).then(response => {
          this.asb_params = response.body;
        }, response => {
          // error callback
        })
      }
    }

</script>
