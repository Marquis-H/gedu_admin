<template>
  <page-form :is-edit="true"/>
</template>
<script>
import PageForm from "./components/PageForm";

export default {
  name: "EditPage",
  components: { PageForm },
  data() {
    return {};
  }
};
</script>