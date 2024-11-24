# Use an official Node.js runtime as a parent image
FROM node:18-alpine

# Ensure the latest version of npm is installed
RUN npm install -g npm@latest

# Set the working directory in the container
WORKDIR /app

# Copy the package.json and package-lock.json (or yarn.lock) to install dependencies
COPY package*.json ./

# Install dependencies
RUN npm ci

# Copy the rest of the application files
COPY . .

# Expose port 3000 (default for Nuxt.js)
EXPOSE 3000

# Build the Nuxt.js app (optional if you're using Nuxt in dev mode)
#RUN npm run build

# Start the Nuxt.js app
CMD ["npm", "run", "dev"]
