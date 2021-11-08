<template>
    <div v-if="values">
        <span
            v-for="(value, index) in values"
            :key="index"
            style="border-radius: 0.325rem"
            class="inline-flex items-center ml-2 mb-1 px-3 py-1 rounded-md text-sm font-medium leading-5 bg-primary text-white"
        >
            {{ value }}
        </span>
    </div>
    <div v-else>—</div>
</template>

<script>
import HandlesFieldValue from "../mixins/HandlesFieldValue";

export default {
    mixins: [HandlesFieldValue],

    props: ["resourceName", "field"],

    computed: {
        values() {
            if (this.isMultiselect) {
                const valuesArray = this.getInitialFieldValuesArray();
                if (!valuesArray || !valuesArray.length) return false;

                const values = valuesArray
                    .map(this.getValueFromOptions)
                    .filter(Boolean)
                    .map(
                        (val) =>
                            `${this.isOptionGroups ? `[${val.group}] ` : ""}${
                                val.label
                            }`
                    );

                if (values.length <= 5) return values;

                return [
                    this.__("novaMultiselect.nItemsSelected", {
                        count: String(values.length || ""),
                    }),
                ];
            } else {
                const value = this.field.options.find(
                    (opt) => String(opt.value) === String(this.field.value)
                );
                return value && value.label;
            }
        },
    },
};
</script>
