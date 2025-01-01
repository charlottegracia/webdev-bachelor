# Use an official Node.js runtime as a parent image
FROM node:20

# Ensure the latest version of npm is installed
RUN npm install -g npm@latest

# Set the working directory in the container
WORKDIR /app

# Copy package.json and package-lock.json to the working directory
COPY package*.json ./

# Install dependencies and log them for debugging
RUN npm ci && npm list

# Copy the rest of the application
COPY . .

# Expose port 3000
EXPOSE 3000

# Start the application
CMD ["npm", "run", "dev"]
