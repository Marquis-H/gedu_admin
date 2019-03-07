<template>
  <page-form :is-edit="true"/>
</template>

<script>
import PageForm from "./components/PageForm";

export default {
  name: "EditContent",
  components: { PageForm },
  data() {
    return {};
  }
};
</script>

<style>
</style>
