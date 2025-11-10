import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'
// import path from 'path';

// https://vite.dev/config/
export default defineConfig({
  plugins: [react()],
  server: {
    // origin: 'http://localhost:5173', // Ensure a consistent origin for the dev server    
    proxy: {
      '/api': {
        target: 'http://localhost:8080', 
        changeOrigin: true,
        secure: false,
        // rewrite: (path) => path.replace(/^\/api/, '/api'),
      },
    },
  },  
  // base: '/dist/', // Base public path for assets (relative to CI's public folder)
  // build: {
  //   outDir: path.resolve(__dirname, '../public/dist'), // Output to CodeIgniter's public/dist    
  //   emptyOutDir: true,
  //   manifest: true, // Generate a manifest file for asset mapping
  //   rollupOptions: {
  //     // Ensure the entry point is specific
  //     input: '/src/main.tsx',
  //   },
  // },

})


/**
   server: {
    proxy: {
      // Proxy requests starting with '/api'
      '/api': {
        target: 'http://localhost:5000', // Your backend server address
        changeOrigin: true, // Changes the origin of the host header to the target URL
        // Option to rewrite the path:
        // rewrite: (path) => path.replace(/^\/api/, '') 
      },
      // You can add multiple proxy rules
      '/auth': {
        target: 'https://your-auth-server.com',
        changeOrigin: true,
        secure: false, // Set to false if targeting an insecure (HTTP) server from an HTTPS dev server
        ws: true, // Proxy web sockets
      },
    },
  },*
 * 
 * 
 * 
 */
