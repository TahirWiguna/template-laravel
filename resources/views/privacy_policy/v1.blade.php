@extends('public.parent')

@section('title', 'Privacy Policy')

@section('styles')

@endsection

@section('breadcrum')
  <div class="col-lg-6 col-7">
    <h6 class="h2 text-white d-inline-block mb-0">Privacy Policy</h6>
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
      <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
        <li class="breadcrumb-item"><a href="#"><i class="ni ni-tv-2"></i></a></li>
      </ol>
    </nav>
  </div>
@endsection

@section('page')
  <div class="row">
    <div class="col-xl-12 order-xl-1">
      <div class="card">
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col-12">
              <h3 class="mb-0">Privacy Policy</h3>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <h1>Privacy Policy for {{ env('APP_NAME') }} Android Application</h1>
              <p>Effective Date: 04-Juni-2023</p>
              
              <h2>1. Information Collection</h2>
              <h3>1.1 Personal Information</h3>
              <p>When you use our App, we may collect certain personal information, including but not limited to:</p>
              <ul>
                <li>Contact Information: We may collect your name, email address, phone number, and other identities. If you choose to provide them for support or communication purposes.</li>
                <li>Device Information: We may collect information about your mobile device, including its unique device identifier, operating system version, and other technical details necessary for the App to function correctly.</li>
              </ul>
              
              <h3>1.2 Non-Personal Information</h3>
              <p>We may also collect non-personal information that does not directly identify you. This information may include aggregated data, statistics, and usage patterns related to your interaction with the App.</p>
              
              <h2>2. Information Use</h2>
              <h3>2.1 Personal Information</h3>
              <p>We may use the personal information collected from you for the following purposes:</p>
              <ul>
                <li>Communication: To respond to your inquiries, provide customer support, and send important notices or updates regarding the App.</li>
                <li>Improvements: To analyze usage trends and patterns, improve the App's functionality, and enhance your overall user experience.</li>
              </ul>
              
              <h3>2.2 Non-Personal Information</h3>
              <p>We may use non-personal information for statistical analysis, research, and other purposes to improve our services, understand user preferences, and optimize the App's performance.</p>
              
              <h2>3. Information Sharing</h2>
              <h3>3.1 Service Providers</h3>
              <p>We may engage trusted third-party service providers to assist us in delivering and improving our services. These providers may have access to your personal information solely for the purposes of performing services on our behalf and are obligated not to disclose or use it for any other purpose.</p>
              
              <h3>3.2 Legal Requirements</h3>
              <p>We may disclose your personal information if required to do so by law or if we believe that such action is necessary to comply with legal obligations, protect our rights and property, or investigate, prevent, or take action regarding potential or suspected illegal activities, fraud, or security issues.</p>
              
              <h3>3.3 Consent</h3>
              <p>We will not share your personal information with third parties for marketing or advertising purposes without your prior consent.</p>
              
              <h2>4. Data Security</h2>
              <p>We take reasonable measures to protect the confidentiality and security of your personal information. However, please note that no method of data transmission or storage can guarantee absolute security. We encourage you to use strong passwords and ensure the security of your mobile device to help protect your information.</p>
              
              <h2>5. Children's Privacy</h2>
              <p>The Application is not intended for use by individuals under the age of 13. We do not knowingly collect personal information from children under 13. If we become aware that we have inadvertently collected personal information from a child under 13, we will promptly delete such information from our records.</p>
              
              <h2>6. Changes to this Privacy Policy</h2>
              <p>We reserve the right to update or modify this Privacy Policy at any time. Any changes will be effective immediately upon posting the revised Privacy Policy. You are encouraged to review this Privacy Policy periodically for any changes.</p>
              
              <h2>7. Contact Us</h2>
              <p>If you have any questions or concerns about this Privacy Policy or our privacy practices, please contact us at <a href="mailto:dev.kriyanesia@gmail.com">dev.kriyanesia@gmail.com</a>.</p>
              
              <p>By using the {{ env('APP_NAME') }} Android Application, you acknowledge that you have read and understood this Privacy Policy and agree to its terms and conditions.</p>
            </div>

          </div>

        </div>
      </div>
    </div>
  </div>
@endsection