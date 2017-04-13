<template>
  <modalvue :showModal="showModal" :closeAction="closeAction">
    <h1 slot="header">Full Dialog</h1>
    <span slot="body">
      Not such a <strong>fool!</strong>
    </span>
    <div slot="footer">
      <button @click="clickAction">Start again</button>
    </div>
  </modalvue>
</template>

<script>
    import modalvue from 'modal-vue'
    export default {
      props: ['showModal', 'closeAction', 'clickAction'],
      components: { 'modalvue' : modalvue },
    }

</script>
