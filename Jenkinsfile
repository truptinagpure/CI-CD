pipeline {
    agent any

    environment {
        IMAGE_NAME = "cicd-com"
        DOCKER_TAG = "build-${BUILD_NUMBER}"   // 👈 Dynamic build-based version
        LATEST_TAG = "latest"
    }

    stages {
        stage("🧹 Clean Workspace") {
            steps {
                echo "Cleaning Jenkins workspace"
                deleteDir()
            }
        }

        stage("📥 Clone Code") {
            steps {
                echo "Cloning GitHub repository"
                git url: "https://github.com/truptinagpure/CI-CD.git", branch: "main"
            }
        }

        stage("🧹 Force Remove Conflicting Containers") {
            steps {
                echo "Removing any pre-existing conflicting containers"
                sh """
                    docker ps -a | grep somaiyacom-db && docker rm -f somaiyacom-db || true
                    docker ps -a | grep somaiyacom-app && docker rm -f somaiyacom-app || true
                """
            }
        }

        stage("🛠️ Build Docker Image") {
            steps {
                echo "Building Docker image with cache and tagging"
                sh """
                    docker pull \$DOCKERHUB_USER/\$IMAGE_NAME:\$DOCKER_TAG || true
                    docker build --cache-from=\$DOCKERHUB_USER/\$IMAGE_NAME:\$DOCKER_TAG \\
                        -t \$IMAGE_NAME:\$DOCKER_TAG \\
                        -t \$IMAGE_NAME:\$LATEST_TAG .
                """
            }
        }

        stage("📦 Push to Docker Hub") {
            steps {
                echo "Pushing both versioned and latest tags to Docker Hub"
                withCredentials([usernamePassword(credentialsId: "dockerHubSom", passwordVariable: 'dockerHubPass', usernameVariable: 'dockerHubUser')]) {
                    sh """
                        docker login -u \$dockerHubUser -p \$dockerHubPass
                        docker tag \$IMAGE_NAME:\$DOCKER_TAG \$dockerHubUser/\$IMAGE_NAME:\$DOCKER_TAG
                        docker tag \$IMAGE_NAME:\$LATEST_TAG \$dockerHubUser/\$IMAGE_NAME:\$LATEST_TAG
                        docker push \$dockerHubUser/\$IMAGE_NAME:\$DOCKER_TAG
                        docker push \$dockerHubUser/\$IMAGE_NAME:\$LATEST_TAG
                    """
                }
            }
        }

        stage("🚀 Deploy Application") {
            steps {
                echo "Deploying using docker-compose"
                withCredentials([usernamePassword(credentialsId: "dockerHubSom", passwordVariable: 'dockerHubPass', usernameVariable: 'dockerHubUser')]) {
                    sh """
                        docker login -u \$dockerHubUser -p \$dockerHubPass
                        docker-compose down --remove-orphans || true
                        docker rm -f somaiyacom-app somaiyacom-db || true
                        docker-compose pull || true
                        docker-compose up -d
                    """
                }
            }
        }

        stage("🧼 Cleanup Docker") {
            steps {
                echo "Cleaning up unused Docker resources"
                sh "docker system prune -f"
            }
        }
    }
}
