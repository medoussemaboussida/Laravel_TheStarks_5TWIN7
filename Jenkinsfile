// Mailing functions
def success() {
    def imageUrl = 'https://semaphoreci.com/wp-content/uploads/2020/02/cic-cd-explained.jpg'
    def imageWidth = '800px'
    def imageHeight = 'auto'

    echo "Sending success email..."
    emailext(
        body: """
        <html>
        <body>
            <p>The Jenkins job was successful.</p>
            <p>You can view the build at: <a href="${BUILD_URL}">${BUILD_URL}</a></p>
            <p><img src="${imageUrl}" alt="Your Image" width="${imageWidth}" height="${imageHeight}"></p>
        </body>
        </html>
        """,
        subject: "Jenkins Build - Success",
        to: 'medoussemaboussida@gmail.com',
        from: 'medoussemaboussida@gmail.com',
        replyTo: 'medoussemaboussida@gmail.com',
        mimeType: 'text/html'
    )
    echo "Success email sent."
}

def failure() {
    def imageUrl = 'https://miro.medium.com/v2/resize:fit:4800/format:webp/1*ytlj68SIRGvi9mecSDb52g.png'
    def imageWidth = '800px'
    def imageHeight = 'auto'

    echo "Sending failure email..."
    emailext(
        body: """
        <html>
        <body>
            <p>Oops! The Jenkins job Failed.</p>
            <p>You can view the build at: <a href="${BUILD_URL}">${BUILD_URL}</a></p>
            <p><img src="${imageUrl}" alt="Your Image" width="${imageWidth}" height="${imageHeight}"></p>
        </body>
        </html>
        """,
        subject: "Jenkins Build - Failure",
        to: 'medoussemaboussida@gmail.com',
        from: 'medoussemaboussida@gmail.com',
        replyTo: 'medoussemaboussida@gmail.com',
        mimeType: 'text/html'
    )
    echo "Failure email sent."
}

pipeline {
    agent any
    stages {
        stage('Checkout GIT') {
            steps {
                echo 'Pulling ...'
                git branch: 'main',
                    url: 'https://github.com/medoussemaboussida/Laravel_TheStarks_5TWIN7.git'
            }
        }
        stage('Setup Environment') {
            steps {
                echo 'Setting up PHP and Composer environment...'
                sh '''
                    # Install Composer if not present
                    if ! command -v composer &> /dev/null; then
                        echo "Installing Composer..."
                        curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
                    else
                        echo "Composer already installed."
                    fi
                    
                    # Ensure PHP is available (assuming it's installed; adjust if needed)
                    if ! command -v php &> /dev/null; then
                        echo "PHP not found. Please ensure PHP is installed on the agent."
                        exit 1
                    fi
                '''
                echo 'Environment setup completed.'
            }
        }
        stage('Unit Tests') {
            steps {
                echo 'Running unit tests for tests/Unit/ExampleTest.php...'
                sh 'composer install --no-progress --no-interaction'
                sh 'php artisan test tests/Unit/ExampleTest.php'
                echo 'Unit tests completed.'
            }
        }
        stage("SonarQube Analysis") {
            steps {
                script {
                    // 🔹 Récupère le scanner configuré dans Jenkins
                    def scannerHome = tool 'scanner'

                    // 🔹 Exécute l’analyse SonarQube
                    withSonarQubeEnv('scanner') {
                        sh """
                            ${scannerHome}/bin/sonar-scanner \
                            -Dsonar.projectKey=laravel-thestarks-5twin7 \
                            -Dsonar.projectName=Laravel_TheStarks_5TWIN7 \
                            -Dsonar.sources=. \
                            -Dsonar.exclusions=vendor/**,node_modules/**,storage/**,bootstrap/cache/**
                        """
                    }
                }
            }
        }
        stage('Start Prometheus') {
            steps {
                sh 'docker start prometheus'
                echo 'Prometheus started.'
            }
        }
        stage('Start Grafana') {
            steps {
                sh 'docker start grafana'
                echo 'Grafana started.'
            }
        }
    }
    // Mailing functions
    post {
        success {
            script {
                success()
            }
        }
        failure {
            script {
                failure()
            }
        }
    }
}