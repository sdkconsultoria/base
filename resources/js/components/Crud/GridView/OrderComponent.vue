<template>
  <th
    scope="col"
    class="
      px-6
      py-3
      text-left text-xs
      font-medium
      text-gray-500
      uppercase
      tracking-wider
    "
  >
    <label @click="setOrderToUrl(field)" class="cursor-pointer"
      >{{ label }} {{ getOrderSymbol(field) }}</label
    >
  </th>
</template>

<script>
export default {
  name: "Order",
  props: {
    field: String,
    current_order: Object,
    label: String,
  },
  data() {
    return {
      // current_order: {
      //   field: "",
      //   order: "",
      // },
      new_order: {
        field: "",
        order: "",
      },
      query_params: new URLSearchParams(window.location.search),
    };
  },
  mounted() {
    this.setCurrentOrder();
  },
  methods: {
    getOrderSymbol(field) {
      if (field == this.current_order.field) {
        if (this.current_order.order == "-") {
          return "↑";
        }
        return "↓";
      }
    },
    setOrderToUrl(field) {
      if (this.current_order.field == field) {
        this.new_order.order = this.current_order.order == "-" ? "" : "-";
      }

      this.new_order.field = field;

      this.query_params.set(
        "order",
        this.new_order.order + this.new_order.field
      );
      history.pushState(null, null, `?${this.query_params.toString()}`);
      this.$parent.fetchData(
        this.$parent.api + `?${this.query_params.toString()}`
      );

      this.$parent.current_order = this.new_order;
    },
    setCurrentOrder() {
      this.query_params = new URLSearchParams(window.location.search);

      let order = this.query_params.get("order");

      if (order) {
        if (order.includes("-")) {
          order = order.replace("-", "");
          this.current_order.order = "-";
        }
        this.current_order.field = order;
      }
    },
  },
};
</script>
