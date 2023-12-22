import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/admin/js/dashboard.js',
                'resources/admin/js/next-link.js',
                'resources/admin/js/table-data.js',
                'resources/common/css/loading.css',
                'resources/common/js/login.js',
                'resources/admin/js/user-create.js',
                'resources/common/js/form.js',
                'resources/common/css/form.css',
                'resources/admin/js/toast-message.js',
                'resources/admin/js/product.js',
                'resources/admin/css/product.css',
                'resources/admin/css/form-edit.css',
                'resources/client/js/register.js',
                'resources/client/css/auth.css',
                'resources/client/js/product-detail.js',
                'resources/client/js/checkout.js',
                'resources/client/css/cart.css',
                'resources/client/css/checkout.css',
                'resources/client/css/product-detail.css',
                'resources/client/css/search.css',
                'resources/client/js/show-product.js',
                'resources/client/css/product-review.css',
                'resources/admin/js/product-color.js',
                'resources/admin/js/size.js',
                'resources/admin/js/edit-product.js',
                'resources/admin/js/setting.js',
                'resources/client/css/home.css',
                'resources/client/js/profile.js',
            ],
            refresh: true,
        }),
    ],
});
