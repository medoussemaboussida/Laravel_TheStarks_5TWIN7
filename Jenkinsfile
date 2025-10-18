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
    agent {
        docker {
            image 'php:8.2-cli'  // Clean PHP env; pulls Java/tools as needed
            args '-u root --entrypoint=""'  // Run as root for installs; disables default entrypoint
        }
    }
    stages {
        stage('Checkout GIT') {
            steps {
                echo 'Pulling ...'
                git branch: 'main',
                    url: 'https://github.com/medoussemaboussida/Laravel_TheStarks_5TWIN7.git'
            }
        }
        stage("SonarQube Analysis") {
            steps {
                script {
                    // Inline SonarScanner download/setup (runs every build, but fast)
                    sh '''
                        # Install minimal deps (wget, unzip, Java)
                        apt-get update && apt-get install -y wget unzip openjdk-17-jre-headless
                        
                        # Download and extract SonarScanner
                        wget https://binaries.sonarsource.com/Distribution/sonar-scanner-cli/sonar-scanner-cli-7.3.0.5189-linux-x64.zip
                        unzip sonar-scanner-cli-7.3.0.5189-linux-x64.zip
                        
                        # Add to PATH for this stage
                        export PATH=$(pwd)/sonar-scanner-7.3.0.5189-linux/bin:$PATH
                        
                        # Test
                        sonar-scanner -h
                    '''
                    // Run scan against your SonarQube container (assumes config in Jenkins plugin)
                    withSonarQubeEnv('scanner') {
                        sh 'sonar-scanner'
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