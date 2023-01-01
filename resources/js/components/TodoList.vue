<template>
    <div class="m-4">
        <h2>TODO APP</h2>
        <button class="btn btn-primary" @click="isHidden = true" v-if="!update">Add an item</button>
        <form v-show="isHidden">
            <div class="form-group">
                <label for="formGroupExampleInput">Name</label>
                <input
                    type="text"
                    class="form-control"
                    id="formGroupExampleInput"
                    placeholder="Enter Item Name"
                    v-model="list.name"
                />
            </div>

            <div class="form-group">
                <label for="formGroupExampleInput2">Price</label>
                <input
                    type="text"
                    class="form-control"
                    id="formGroupExampleInput2"
                    placeholder="Enter Price"
                    v-model="list.price"
                />
            </div>
            <button
                type="submit"
                class="btn btn-primary"
                @click.prevent="addItem()"
                v-if="!update"
            >
                Submit
            </button>
            <button
                type="submit"
                class="btn btn-primary"
                @click.prevent="updateItem()"
                v-if="update"
            >
                Update
            </button>
        </form>
        <div class="mt-2" v-if="items.length">
            <h2>List of users</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Operations</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, i) in items" :key="i">
                        <td>{{ item.name }}</td>
                        <td>{{ item.price }}</td>
                        <td>
                            <button
                                style="margin-right: 8px"
                                @click.prevent="deleteItem(item)"
                            >
                                Delete
                            </button>
                            <button @click.prevent="Update(item)">
                                Update
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    name: "TodoList",
    data() {
        return {
            isHidden: false,
            update: false,
            itemId: null,
            list: {
                name: "",
                price: null,
            },
            items: [],
        };
    },
    mounted() {
        this.loadItem();
    },
    methods: {
        async loadItem() {
            console.log("items:", this.items);
            try {
                const { data } = await axios.get("/api/item");
                console.log("res is:", data.items);
                this.items = data.items;
            } catch (e) {
                console.log("error is:", e);
            }
        },
        async addItem() {
            try {
           
                if (this.list.name == "") {
                    alert("Name field is required")
                    return;
                }
                if (this.list.price == null) {
                    alert("Price field is required")
                    return;
                }
                const { data } = await axios.post("/api/item/store", {
                    name: this.list.name,
                    price: this.list.price,
                });

                if (data) {
                    this.list.name = "";
                    this.list.price = null;
                }
                this.loadItem();
            } catch (e) {
                console.log("error is:", e);
            }
        },
        async deleteItem(item) {
            console.log("item is:", item);
            try {
                if (confirm("Are you sure you want to delete item") == true) {
                    const { dt } = await axios.delete("/api/item/" + item.id);
                    this.loadItem();
                }
            } catch (e) {
                console.log("error is:", e);
            }
        },
        Update(item) {
            this.isHidden = true;
            this.update = true;
            this.itemId = item.id;
            this.list = {
                name: item.name,
                price: item.price,
            };
        },
        async updateItem() {
            try {
                await axios.patch("/api/item/" + this.itemId, {
                    name: this.list.name,
                    price: this.list.price,
                });
                this.list.name = "";
                this.list.price = null;
                this.update = false;
                this.isHidden = false;
                this.loadItem();
            } catch (e) {
                console.log("error is:", e);
            }
        },
    },
};
</script>
