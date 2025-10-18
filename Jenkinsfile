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
        stage("SonarQube Analysis") {
            steps {
                script {
                    sh '''
                        # Clean any old ZIP
                        rm -f sonar-scanner-cli-7.3.0.5189-linux-x64.zip*
                        
                        # Install minimal deps if not present
                        apt-get update || true
                        apt-get install -y wget python3 || true
                        
                        # Download SonarScanner
                        wget -O sonar-scanner-cli-7.3.0.5189-linux-x64.zip https://binaries.sonarsource.com/Distribution/sonar-scanner-cli/sonar-scanner-cli-7.3.0.5189-linux-x64.zip
                        
                        # Extract with Python
                        python3 -c "
import zipfile
with zipfile.ZipFile('sonar-scanner-cli-7.3.0.5189-linux-x64.zip', 'r') as zip_ref:
    zip_ref.extractall('.')
"
                        
                        # Verify extraction and PATH
                        ls -la sonar-scanner-7.3.0.5189-linux/bin/sonar-scanner
                        export PATH=$(pwd)/sonar-scanner-7.3.0.5189-linux/bin:$PATH
                        sonar-scanner -h
                    '''
                    withSonarQubeEnv('scanner') {
                        sh 'sonar-scanner'
                    }
                }
            }
        }
        stage('Start Prometheus') {
            steps {
                sh 'docker start prometheus || true'
                echo 'Prometheus started or already running.'
            }
        }
        stage('Start Grafana') {
            steps {
                sh 'docker start grafana || true'
                echo 'Grafana started or already running.'
            }
        }
    }
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