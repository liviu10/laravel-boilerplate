<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Content;
use Carbon\Carbon;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Content::truncate();
        $records = [
            [
                'id' => 1,
                'content_visibility_id' => 1,
                'scheduled_on' => null,
                'content_url' => config('app.url'),
                'content_slug' => 'guest',
                'title' => 'Welcome',
                'content_type_id' => 1,
                'content_category_id' => 1,
                'description' => 'This is the welcome page',
                'content' => <<<END
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                    when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                    It has survived not only five centuries, but also the leap into electronic typesetting,
                    remaining essentially unchanged. It was popularised in the 1960s with the release of
                    Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing
                    software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                END,
                'allow_comments' => false,
                'allow_share' => false,
                'is_admin' => false,
                'is_guest_home' => true,
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'content_visibility_id' => 1,
                'scheduled_on' => null,
                'content_url' => config('app.url') . '/terms-and-conditions',
                'content_slug' => 'terms-and-conditions',
                'title' => 'Terms and Conditions',
                'content_type_id' => 1,
                'content_category_id' => 1,
                'description' => 'This is the terms and conditions page',
                'content' => <<<END
                    <p>Welcome to <span id="M_C1">Laravel boilerplate</span>!</p>
                    <p>These terms and conditions lay forth the groundwork for using <span id="M_C2">Laravel boilerplate</span> website, which may be found at <span id="M_Curl">http://127.0.0.1:8000/</span></p>
                    <p>We assume that by accessing this website, you agree to these terms and conditions. If you do not agree to all of the terms and conditions listed on this page, do not use <span id="M_C3">Laravel boilerplate</span>.</p>
                    <p>These Terms and Conditions, Privacy Statement and Disclaimer Notice, and all Agreements are governed by the following terminology: "Client," "You," and "Your" refer to you, the person who logs on to this website and agrees to the Company's terms and conditions. Our Company is referred to as "The Company," "Ourselves," "We," "Ours," and "Us." Both the Client and ourselves are referred to as "Party," "Parties," or "Us."All terms refer to the offer, acceptance, and consideration of payment necessary to begin the process of our assistance to the Client in the most appropriate manner for the express purpose of meeting the Client's needs in respect of the Company's specified services, in line with and subject to, applicable Dutch legislation. Any use of the above language, as well as other words in the singular, plural, capitalization, and/or he/she or they, is assumed to mean the same thing.</p>
                    <h3><strong>Cookies</strong></h3>
                    <p>Cookies are used on this site. You accepted to use cookies in accordance with the <span id="M_C4">Laravel boilerplate</span> Privacy Policy by visiting <span id="M_C5">Laravel boilerplate</span></p>
                    <p>Cookies are used by most interactive websites to allow us to retrieve the user's information for each visit. Cookies are used on our website to allow specific areas to work and to make things easier for users. Certain of our affiliate/advertising partners may also utilize cookies.</p>
                    <h3><strong>License</strong></h3>
                    <p>Unless otherwise stated, all intellectual property rights in all material on <span id="M_C6">Laravel boilerplate</span> are owned by <span id="M_C7">Laravel boilerplate</span> and/or its licensors. All rights to intellectual property are reserved. You may use this for your own personal use from <span id="M_C8">Laravel boilerplate</span>, subject to the restrictions set forth in these terms and conditions.</p>
                    <p>You must not:</p>
                    <ul>
                    <li>Republish material from <span id="M_C9">Laravel boilerplate</span></li>
                    <li>Sell, rent, or sub-license material from <span id="M_C10">Laravel boilerplate</span></li>
                    <li>Reproduce, duplicate or copy material from <span id="M_C11">Laravel boilerplate</span></li>
                    <li>Redistribute content from <span id="M_C12">Laravel boilerplate</span></li>
                    </ul>
                    <p>This agreement's term begins on the date hereof. The <a href="https://www.blogearns.com/2021/05/free-terms-and-conditions-generator.html">Terms And Conditions Generator</a> and the <a href="https://www.blogearns.com/2021/05/generate-privacy-policy-for-websites.html">Privacy Policy Generator</a> were used to construct our Terms and Conditions.</p>
                    <p>Parts of this website allow users to post and exchange thoughts and information in designated places. Prior to their appearance on the Internet, <span id="M_C13">Laravel boilerplate</span> does not filter, edit, publish, or review Comments. The thoughts and opinions expressed in the comments do not reflect those of <span id="M_C14">Laravel boilerplate</span>, its agents, or affiliates. The views and opinions expressed in comments reflect the views and opinions of the individual who posted them. <span id="M_C15">Laravel boilerplate</span> shall not be liable for the Comments or for any liabilities, damages, or expenses caused and/or suffered as a result of the use of and/or posting of and/or appearance of the Comments on this website, to the extent permitted by applicable laws.</p>
                    <p><span id="M_C16">Laravel boilerplate</span> has the right to review all Comments and to remove any Comments that are inappropriate, offensive, or violate our Terms and Conditions.</p>
                    <p>You warrant and represent that:</p>
                    <ul>
                    <li>You have the essential rights and consent to post the Comments on our website, and you have been given permission to do so.</li>
                    <li>No third-party intellectual property rights, such as copyright, patents, or trademarks, are infringed upon by the Comments.</li>
                    <li>In the Comments, there is no defamatory, libelous, offensive, indecent, or otherwise unlawful content that constitutes a privacy invasion.</li>
                    <li>The Comments will not be used to solicit or promote any type of business, custom, or current commercial or illegal activity.</li>
                    </ul>
                    <p>You hereby grant <span id="M_C17">Laravel boilerplate</span> a non-exclusive license to use, reproduce, edit, and authorize others to use, reproduce, edit, and authorize others to use, reproduce, edit, and authorize others to use, reproduce, and edit any of your Comments in any form, format, or media.</p>
                    <h3><strong>Hyperlinking to our Content</strong></h3>
                    <p>Without prior written permission, the following organizations may link to our website:</p>
                    <ul>
                    <li>Government agencies;</li>
                    <li>Search engines;</li>
                    <li>News organizations;</li>
                    <li>Distributors of online directories may link to our website in the same way that they connect to the websites of other businesses included in the directory.; and</li>
                    <li>Except for soliciting non-profit organizations, charity shopping malls, and charity fundraising clubs, which are not permitted to link to our website.</li>
                    </ul>
                    <p>These organizations may link to our home page, publications, or other Website content as long as the link complies with the following criteria: (a) is not in any way deceptive; (b) does not suggest that the connecting party or its products and/or services are sponsored, endorsed, or approved in any way; and (c) ties nicely with the theme of the linking party's website.</p>
                    <p>Other link requests from the following categories of organizations may be considered and approved:</p>
                    <ul>
                    <li>commonly-known consumer and/or business information sources;</li>
                    <li>dot.com community sites;</li>
                    <li>associations or other groups representing charities;</li>
                    <li>online directory distributors;</li>
                    <li>internet portals;</li>
                    <li>accounting, law, and consulting firms; and</li>
                    <li>educational institutions and trade associations.</li>
                    </ul>
                    <p>We will approve link requests from these organizations if we determine that: (a) the link will not reflect poorly on us or our accredited businesses; (b) the organization has no negative records with us; (c) the benefit to us from the visibility of the hyperlink compensates for the absence of <span id="M_C18">Laravel boilerplate</span> and (d) the link will be in the context of general resource information.</p>
                    <p>These organizations are welcome to link to our home page as long as the link: (a) is not misleading; (b) does not falsely imply sponsorship, endorsement, or approval of the linking party or its products or services; and (c) is appropriate for the linking party's website.</p>
                    <p>Please contact us by email at <span id="M_C19">Laravel boilerplate</span> if you are one of the organizations listed in paragraph 2 above and would want to link to our website. Include your name, the name of your organization, contact information, and the URL of your website, as well as a list of any URLs from which you intend to link to our site and a list of the URLs on our site to which you would like to connect. Expect a response in two to three weeks.</p>
                    <p>Approved organizations may use the following URL to link to our website:</p>
                    <ul>
                    <li>By use of our corporate name; or</li>
                    <li>The usage of a unified resource locator (URL) that is linked to; or</li>
                    <li>By describing our Website in any other way that makes sense in the context and format of the linked party's website's content.</li>
                    </ul>
                    <p>There will be no use of <span id="M_C20">Laravel boilerplate</span> logo or any artwork for linking without a trademark license agreement.</p>
                    <h3><strong>iFrames</strong></h3>
                    <p>Without prior approval and written agreement, you may not put frames around our Webpages that alter the visual presentation or look of our Website.</p>
                    <h3><strong>Content Liability</strong></h3>
                    <p>We are not responsible for any of the content on your website. You agree to defend and indemnify us in the event of any disputes arising from your Website. On any Website, there should be no link(s) that could be regarded as defamatory, obscene, or illegal, or that infringes, otherwise violates, or encourages the infringement or other violation of any third-party rights.</p>
                    <h3><strong>Your Privacy</strong></h3>
                    <p>Please read Privacy Policy</p>
                    <h3><strong>Reservation of Rights</strong></h3>
                    <p>We reserve the right to request that you delete any and all connections to our Website or particular links to our Website. Upon our request, you undertake to immediately disconnect any connections to our website. These terms and conditions, as well as the linking policy, are subject to change at any time. If you continue to link to our Website, you agree to be bound by and comply with these linking terms and conditions.</p>
                    <h3><strong>Removal of links from our website</strong></h3>
                    <p>If you find any link on our Website that is offensive for any reason, you are invited to contact us and notify us at any time. We will examine requests to remove links, but we are not obligated to do so or to respond to you personally.</p>
                    <p>We offer no assurances that the information on this website is correct, complete, or accurate, that the website will be available, or that the material on the website will be kept up to date.</p>
                    <h3><strong>Disclaimer</strong></h3>
                    <p>To the largest extent permitted by applicable law, we disclaim any and all claims, warranties, and conditions relating to this website and its use. Nothing in this disclaimer should be construed as:</p>
                    <ul>
                    <li>minimize or eliminate our or your responsibility in the case of death or personal injury</li>
                    <li>limit or exclude our or your liability for fraud or dishonesty;</li>
                    <li>limit any of our or your liabilities in any way that is not allowed by law; or</li>
                    <li>exclude any of our or your liabilities that are not permitted by relevant law to be excluded.</li>
                    </ul>
                    <p>The liability restrictions and prohibitions set out in this section and elsewhere in this disclaimer are as follows: (a) are bound by the provisions of the previous paragraph; and (b) All responsibilities arising under the disclaimer are regulated by these terms, including those originating in contract, tort, or for breach of statutory duty.</p>
                    <p>We will not be liable for any loss or damage of any kind as long as the website and the information and services on the website are offered free of charge.</p>
                END,
                'allow_comments' => false,
                'allow_share' => false,
                'is_admin' => false,
                'is_guest_home' => false,
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'content_visibility_id' => 1,
                'scheduled_on' => null,
                'content_url' => config('app.url') . '/privacy-policy',
                'content_slug' => 'privacy-policy',
                'title' => 'Privacy policy',
                'content_type_id' => 1,
                'content_category_id' => 1,
                'description' => 'This is the privacy policy page',
                'content' => <<<END
                    <p>One of our top priorities, which can be found at, is the privacy of our visitors. This paper outlines the types of information that collects and records, as well as how we use it.</p>
                    <p>Please do not hesitate to contact us if you have any further questions or need additional details about our Privacy Policy.</p>
                    <p>This Privacy Policy only applies to our online activities and is applicable to information exchanged and/or collected by visitors to our website. This policy does not extend to data collected outside of this website or by other means. The <a style="color: inherit; text-decoration: none;" href="https://www.blogearns.com/2021/05/generate-privacy-policy-for-websites.html"> Privacy Policy Generator</a> was used to build our Privacy Policy.</p>
                    <h2>Consent</h2>
                    <p>Through using our website <span id="W_URL">http://127.0.0.1:8000/</span>, you consent to and adhere to the terms of our Privacy Policy.</p>
                    <h2>Information we collect</h2>
                    <p>The personal information you are asked to provide, as well as the reasons for doing so, will be explained to you at the time you are asked to do so.</p>
                    <p>If you contact us directly, we can obtain additional information about you, such as your name, email address, phone number, the contents of any message and/or attachments you send us, and any other information you choose to provide.</p>
                    <p>We can ask for your contact information when you create an Account, such as your name, company name, address, email address, and phone number.</p>
                    <h2>How we use your information</h2>
                    <p>We use the data we gather in a variety of ways, including:</p>
                    <ul>
                    <li>Provide, operate, and maintain our website</li>
                    <li>Improve, personalize, and expand our website</li>
                    <li>Recognize and evaluate how you use our website.</li>
                    <li>Create new products, services, features, and capabilities.</li>
                    <li>Interact with you, either directly or through one of our partners, for a variety of reasons, including customer support, providing you with website updates and other material, and marketing and promotional purposes.</li>
                    <li>Send you emails</li>
                    <li>Find and prevent fraud</li>
                    </ul>
                    <h2>Log Files</h2>
                    <p>The use of log files is common practice. When people visit websites, these files record their identities. As part of their analytics, all hosting companies perform this task. Log files collect information such as IP addresses, browser versions, Internet Service Providers (ISPs), date and time stamps, referring/exit sites, and possibly the number of clicks. They are not connected to any personally identifiable information. The information is collected to analyze patterns, operate the platform, monitor users' movements on the site, and gather demographic information.</p>
                    <h2>Cookies and Web Beacons</h2>
                    <p><span id="W_6">Laravel boilerplate</span>, like every other website, uses 'cookies.' These cookies are used to save information such as visitor interests and which pages on the website they accessed or visited. We can enhance the user experience by customizing our web page content based on visitors' browser type and/or other information.</p>
                    <p>Please read <a href="https://www.blogearns.com/2021/05/generate-privacy-policy-for-websites.html#cookie">"What Are Cookies"</a> for more general information on cookies. from Consent to Cookies</p>
                    <h2>Google DoubleClick DART Cookie</h2>
                    <p>On our platform, Google is one of the third-party vendors. It also employs DART cookies to target advertisements to our site users based on their visits to www.website.com and other websites on the internet. Visitors can opt-out of the use of DART cookies by going to the Google ad and content network Privacy Policy at the following URL &ndash; "<a href="https://policies.google.com/technologies/ads">https://policies.google.com/technologies/ads</a>"</p>
                    <h2>Advertising Partners Privacy Policies</h2>
                    <p>You will find the Privacy Policies for each of <span id="W_7">Laravel boilerplate</span>' advertisement partners in this list.</p>
                    <p>Third-party ad servers or ad networks use technologies such as cookies, JavaScript, or Web Beacons in their ads and links, which are delivered directly to users' browsers. When this happens, the IP address is immediately sent to them. These tools are used by advertisers to evaluate the effectiveness of their advertisement campaigns and/or to customize the advertising content you see on websites you visit.</p>
                    <p>It's important to note that has no access to or influence over these third-party cookies.</p>
                    <h2>Third-Party Privacy Policies</h2>
                    <p>Such ads or blogs are not covered by <span id="W_10">Laravel boilerplate</span>' Privacy Policy. As a result, we recommend that you read the Privacy Policies of these third-party ad servers for more details. It may provide details about their operations as well as for instructions about how to opt out of them.</p>
                    <p>By modifying the settings in your browser, you can disable cookies. On the websites of the different web browsers, you can find more detailed details about cookie management.</p>
                    <h2>CCPA Privacy Rights (Please do not sell my personal data)</h2>
                    <p>Consumers in California have the right, among other things, under the CCPA to:</p>
                    <p>Request that a business that collects a consumer's personal data disclose the categories and specific pieces of data it has collected.</p>
                    <p>Request that a company deletes all personal information about a customer that it has acquired.</p>
                    <p>Request that a business that sells a customer's personal details refrain from doing so.</p>
                    <p>If you submit a request, you will receive a response within one month. Please contact us if you wish to exercise any of these rights.</p>
                    <h2>GDPR Data Protection Rights</h2>
                    <p>We want to make sure you <a href="https://www.dataguard.co.uk/gdpr-consultancy" target="_blank" rel="noopener">understand your data privacy rights</a> fully. Any consumer has the following rights:</p>
                    <p>The right to access information &ndash; You have the right to a copy of your personal information. For this service, we will charge you a small fee.</p>
                    <p>The right to rectification &ndash; You have the right to request that any information that you feel is incorrect be corrected. You also have the option of asking us to fill in any information gaps you believe exist.</p>
                    <p>The right to be forgotten &ndash; You have the right to request that we remove your personal data in some situations.</p>
                    <p>The right to limit processing &ndash; Under certain circumstances, you have the right to request that we restrict the processing of your personal data.</p>
                    <p>The right to data portability &ndash; You have the right to suggest that we send the data we've collected to another organization or directly to you under some situations.</p>
                    <p>If you submit any request in this regard, you will receive a response within one month. If you wish to exercise any of these privileges, please contact us.</p>
                    <h2>Children's Information</h2>
                    <p>Our other top priority is to improve internet protection for children. Parents and guardians should keep an eye on, participate in, monitor, and guide their children's online activities.</p>
                    <p><span id="W_11">Laravel boilerplate</span> can not collect personally identifying information from children under the age of thirteen without their consent. If you think your child provided this kind of information on our website, please contact us immediately so that we can remove it from our records.</p>
                END,
                'allow_comments' => false,
                'allow_share' => false,
                'is_admin' => false,
                'is_guest_home' => false,
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        Content::insert($records);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
