'use strict';

const { createApp } = Vue;

createApp({
    data() {
        return {
            apiUrl: 'api/products.php',
            products: [],
            form: { name: '', price: null, stock: 0 },
            editingId: null,
            loading: false,
            saving: false,
            errorMessage: '',
            successMessage: '',
        };
    },

    mounted() {
        this.fetchProducts();
    },

    methods: {
        async requestApi(url, options = {}) {
            const response = await fetch(url, {
                ...options,
                headers: {
                    Accept: 'application/json',
                    ...(options.body ? { 'Content-Type': 'application/json' } : {}),
                    ...(options.headers || {}),
                },
            });

            let payload;
            try {
                payload = await response.json();
            } catch (error) {
                throw new Error('Máy chủ trả về dữ liệu không phải JSON hợp lệ.');
            }

            if (!response.ok || payload.success !== true) {
                throw new Error(payload.message || 'Yêu cầu không thành công.');
            }

            return payload;
        },

        async fetchProducts() {
            this.loading = true;
            this.errorMessage = '';

            try {
                const payload = await this.requestApi(this.apiUrl);
                this.products = Array.isArray(payload.data) ? payload.data : [];
            } catch (error) {
                this.errorMessage = error.message;
            } finally {
                this.loading = false;
            }
        },

        validateForm() {
            const name = String(this.form.name ?? '').trim();
            const price = this.form.price;
            const stock = this.form.stock;

            if (name.length < 1 || [...name].length > 100) {
                throw new Error('Tên sản phẩm phải có từ 1 đến 100 ký tự.');
            }
            if (!Number.isInteger(price) || price <= 0 || price > 2147483647) {
                throw new Error('Đơn giá phải là số nguyên lớn hơn 0.');
            }
            if (!Number.isInteger(stock) || stock < 0 || stock > 2147483647) {
                throw new Error('Số lượng tồn phải là số nguyên không âm.');
            }

            return { name, price, stock };
        },

        async saveProduct() {
            this.errorMessage = '';
            this.successMessage = '';

            let product;
            try {
                product = this.validateForm();
            } catch (error) {
                this.errorMessage = error.message;
                return;
            }

            this.saving = true;
            const isEditing = this.editingId !== null;
            const url = isEditing ? `${this.apiUrl}?id=${this.editingId}` : this.apiUrl;

            try {
                const payload = await this.requestApi(url, {
                    method: isEditing ? 'PUT' : 'POST',
                    body: JSON.stringify(product),
                });

                this.successMessage = payload.message || (isEditing
                    ? 'Cập nhật sản phẩm thành công.'
                    : 'Thêm sản phẩm thành công.');
                this.resetForm();
                await this.fetchProducts();
            } catch (error) {
                this.errorMessage = error.message;
            } finally {
                this.saving = false;
            }
        },

        editProduct(product) {
            this.editingId = Number(product.id);
            this.form = {
                name: product.name,
                price: Number(product.price),
                stock: Number(product.stock),
            };
            this.errorMessage = '';
            this.successMessage = '';
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },

        async deleteProduct(product) {
            const confirmed = window.confirm(`Bạn có chắc chắn muốn xóa sản phẩm "${product.name}" không?`);
            if (!confirmed) return;

            this.errorMessage = '';
            this.successMessage = '';

            try {
                const payload = await this.requestApi(`${this.apiUrl}?id=${product.id}`, {
                    method: 'DELETE',
                });
                this.successMessage = payload.message || 'Xóa sản phẩm thành công.';

                if (this.editingId === Number(product.id)) {
                    this.resetForm();
                }
                await this.fetchProducts();
            } catch (error) {
                this.errorMessage = error.message;
            }
        },

        resetForm() {
            this.form = { name: '', price: null, stock: 0 };
            this.editingId = null;
        },

        formatPrice(value) {
            return `${new Intl.NumberFormat('vi-VN').format(Number(value))} đ`;
        },
    },
}).mount('#app');
