# Medical E-commerce - Render Deployment Guide

This guide will help you deploy your Laravel Medical E-commerce application to Render platform.

## Prerequisites

1. **Render Account**: Sign up at [render.com](https://render.com)
2. **GitHub Repository**: Your code should be in a GitHub repository
3. **Docker Knowledge**: Basic understanding of Docker (optional but helpful)

## Deployment Steps

### 1. Prepare Your Repository

Make sure your repository contains:
- `Dockerfile` (already created)
- `.dockerignore` (already created)
- `env.production.template` (already created)
- All your Laravel application files

### 2. Create a New Web Service on Render

1. **Login to Render Dashboard**
2. **Click "New +"** → **"Web Service"**
3. **Connect your GitHub repository**
4. **Configure the service:**
   - **Name**: `medical-ecommerce` (or your preferred name)
   - **Environment**: `Docker`
   - **Dockerfile Path**: `./Dockerfile`
   - **Plan**: Start with `Starter` (free tier)

### 3. Environment Variables Configuration

In the Render dashboard, go to **Environment** tab and add these variables:

#### Required Variables:
```bash
APP_NAME=Medical E-commerce
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app-name.onrender.com
LOG_LEVEL=error
```

#### Database Configuration (SQLite - Default):
```bash
DB_CONNECTION=sqlite
DB_DATABASE=/var/www/html/database/database.sqlite
```

#### Optional Variables (configure as needed):
```bash
# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@your-domain.com

# AWS S3 (if using file storage)
AWS_ACCESS_KEY_ID=your-aws-key
AWS_SECRET_ACCESS_KEY=your-aws-secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket-name

# Custom Domain (if you have one)
APP_URL=https://your-custom-domain.com
```

### 4. Advanced Settings (Optional)

#### Auto-Deploy:
- Enable **Auto-Deploy** to automatically deploy when you push to main branch

#### Health Check:
- **Health Check Path**: `/` (default Laravel route)
- **Health Check Timeout**: `300 seconds`

#### Build Command:
- The Dockerfile handles all build commands automatically

#### Start Command:
- The Dockerfile handles the start command automatically

### 5. Deploy

1. **Click "Create Web Service"**
2. **Wait for the build process** (5-10 minutes for first deployment)
3. **Monitor the logs** for any errors
4. **Access your application** via the provided Render URL

## Post-Deployment Tasks

### 1. Generate Application Key (if needed)
If you see errors about APP_KEY, you can generate it manually:
```bash
# In Render console or via SSH
php artisan key:generate
```

### 2. Run Additional Commands (if needed)
```bash
# Clear and cache configuration
php artisan config:clear
php artisan config:cache

# Clear and cache routes
php artisan route:clear
php artisan route:cache

# Clear and cache views
php artisan view:clear
php artisan view:cache
```

### 3. Database Management
The application uses SQLite by default, which is perfect for Render's free tier. If you need MySQL/PostgreSQL:

1. **Create a Database service on Render**
2. **Update environment variables** with the new database connection details
3. **Redeploy your application**

## Troubleshooting

### Common Issues:

#### 1. Build Failures
- Check the build logs in Render dashboard
- Ensure all dependencies are properly listed in `composer.json` and `package.json`
- Verify Dockerfile syntax

#### 2. Application Key Errors
- The Dockerfile automatically generates APP_KEY
- If issues persist, manually set it in environment variables

#### 3. Permission Errors
- The Dockerfile sets correct permissions automatically
- If you see storage permission errors, check the Dockerfile permissions section

#### 4. Database Connection Errors
- Ensure DB_DATABASE path is correct: `/var/www/html/database/database.sqlite`
- Check if database directory exists and has correct permissions

#### 5. Asset Loading Issues
- Ensure Vite build completed successfully
- Check if `public/build` directory exists with assets

### Performance Optimization:

#### 1. Enable Caching
The Dockerfile automatically enables:
- Configuration caching
- Route caching
- View caching

#### 2. Database Optimization
- Consider upgrading to a paid database service for production
- Use database indexing for better performance

#### 3. File Storage
- Use AWS S3 or similar for file storage in production
- Configure proper CDN for static assets

## Monitoring and Maintenance

### 1. Logs
- Access logs via Render dashboard
- Monitor for errors and performance issues

### 2. Updates
- Push changes to your main branch for auto-deployment
- Test changes in a staging environment first

### 3. Backups
- SQLite database is included in your application
- Consider regular backups for production data

## Cost Optimization

### Free Tier Limits:
- 750 hours per month
- Automatic sleep after 15 minutes of inactivity
- 512MB RAM
- 0.1 CPU

### Upgrade Considerations:
- **Starter Plan**: $7/month for always-on service
- **Standard Plan**: $25/month for better performance
- **Pro Plan**: $85/month for production workloads

## Security Considerations

1. **Environment Variables**: Never commit sensitive data to repository
2. **HTTPS**: Render provides free SSL certificates
3. **Database**: Use strong passwords and restrict access
4. **Updates**: Keep dependencies updated regularly

## Support

- **Render Documentation**: [render.com/docs](https://render.com/docs)
- **Laravel Documentation**: [laravel.com/docs](https://laravel.com/docs)
- **Docker Documentation**: [docs.docker.com](https://docs.docker.com)

---

**Note**: This deployment uses SQLite by default for simplicity. For production applications with high traffic, consider using PostgreSQL or MySQL database services provided by Render.
