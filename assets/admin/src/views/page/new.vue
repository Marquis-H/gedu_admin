<template>
  <page-form :is-edit="false"/>
</template>
<script>
import PageForm from "./components/PageForm";

export default {
  name: "NewPage",
  components: { PageForm },
  data() {
    return {};
  }
};
</script>