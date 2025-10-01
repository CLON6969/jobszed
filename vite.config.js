import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [ 
                'public/resources/css/nav1.css',
                'public/resources/css/footer.css',
                'public/resources/css/welcome.css',
                'public/resources/css/partners.css',
                'public/resources/css/signup.css',
                'public/resources/css/sigin.css',
                 'public/resources/css/admin_dashboard1.css'
                
    
                



               ],
            refresh: true,
        }),
    ],
});
