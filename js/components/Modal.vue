<template>
    <transition name="modal">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-container">

            <div class="modal-header">
              <slot name="header">
                default header
              </slot>
            </div>

            <div class="modal-body">
              <slot name="body">
                <select v-model=selectedUser>
                  <option disabled value="0">
                    Select User
                  </option>
                  <option v-for="(value, key) in asp_params" :value="value.id">
                    {{value.name}}
                  </option>
                </select>
              </slot>
            </div>
            <div class="modal-body">
              <slot name="body">
                default body
              </slot>
            </div>
            <div class="modal-body">
              <slot name="body">
                default body
              </slot>
            </div>

            <div class="modal-footer">
              <slot name="footer">
                default footer
                <a class="modal-default-button" href="#" @click="$emit('close')">
                  Insert
                </a>
              </slot>
            </div>
          </div>
        </div>
      </div>
    </transition>
</template>

<script>
    export default {

    }

</script>
