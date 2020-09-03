<?php

use Illuminate\Database\Seeder;

class SnippetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('snippets')->delete();

        \DB::table('snippets')->insert([
            0 => [
                'title' => 'agc_acknowledge',
                'label' => 'board',
                'locale' => 'en_US',
                'snippet' =>
                    "Peter Bowler <br />
                    <i>President</i> <br />
                    <br />
                    Mark Vehslage <br />
                    <i>Secretary Treasurer</i> <br />
                    <br />
                    Mary Del Olmo <br />
                    Fr. Holguin <br />
                    John Luna <br />
                    Paul Pederson <br />
                    Richard Rolland <br />
                    Jeannette Santos <br />
                    Fr. Thompson <br /><br />",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            1 => [
                'title' => 'agc_acknowledge',
                'label' => 'jesuits',
                'locale' => 'en_US',
                'snippet' =>
                    "Fr. Rauschuber, S.J.<br />
                    Fr. Gonzales, S.J.<br />
                    Fr. Joseph, S.J.<br />
                    Fr. Vo, S.J.<br />",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            2 => [
                'title' => 'agc_acknowledge',
                'label' => 'letter',
                'locale' => 'en_US',
                'snippet' =>
                    "Dear &#123;&#123;&#36;donation->contact->agc_household_name&#125;&#125;,
                    <br />
                    <br />
                    Jesus promises the door will be opened to those who ask, seek, and knock.
                    We knocked on your door and you generously answered. Thank you for
                    your gift of &#36;&#123;&#123;number_format(&#36;donation->payments_paid,2)&#125;&#125; for &#123;&#123;&#36;donation->donation_description&#125;&#125; supporting Montserrat
                    Jesuit Retreat House. We promise you that it will be put to good use.
                    <br />
                    <br />
                    People need a place to rest and space to pray. At Montserrat, we never get
                    tired of encouraging good people to open their hearts to God&apos;s generous
                    graces. Your gift to the Annual Giving Campaign helps keep Montserrat
                    growing and available to all who need prayer and counsel for their life in
                    Christ. Because of you we can continue to minister to God&apos;s people.
                    <br />
                    <br />
                    Thank you again, and know you are remembered daily in prayers and
                    masses at Montserrat. St. Ignatius offered this blessing to his friends and so
                    we now offer it to you: &quot;May it ever please the Lord to recompense and
                    repay you with his most holy consolations and spiritual blessings and eternal
                    peace.&quot;
                    <br />
                    <br />
                    Peace,
                    <br />
                    <br />
                    <br />
                    <br />
                    Fr. Anthony Rauschuber, S.J.
                    <br />
                    Director
                    <br />",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            3 => [
                'title' => 'agc_acknowledge',
                'label' => '501c3',
                'locale' => 'en_US',
                'snippet' =>
                    "Montserrat Jesuit Retreat House is a ministry of the Society of Jesus UCS Province
                    <br />
                    No goods or services have been provided to the donor.
                    <br />
                    Your donation is deductible to the extent allowed by law.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            4 => [
                'title' => 'agc_acknowledge',
                'label' => 'footer',
                'locale' => 'en_US',
                'snippet' =>
                    "<table style=\"width:100%; margin:auto;\">
                        <tr>
                            <td style=\"width:33%; margin:auto; text-align:center\">PO Box 1390</td>
                            <td style=\"width:33%; margin:auto; text-align:center\">600 N. Shady Shores Dr</td>
                            <td style=\"width:33%; margin:auto; text-align:center\">Lake Dallas, TX 75065<td>
                        </tr>
                            <tr>
                            <td style=\"text-align:center\">(940) 321-6020</td>
                            <td> </td>
                            <td style=\"text-align:center\">montserratretreat.org </td>

                        </tr>
                    </table>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            5 => [
                'title' => 'event-confirmation',
                'label' => 'welcome',
                'locale' => 'en_US',
                'snippet' =>
                    "We are praying for you as your upcoming retreat approaches.
                    You will find a beautiful campus, made holy by the thousands who have prayed here, that is both hospitable and restorative.
                    We greatly look forward to welcoming and accompanying you during the retreat.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            6 => [
                'title' => 'event-confirmation',
                'label' => 'checkin',
                'locale' => 'en_US',
                'snippet' =>
                    "Check-in for your retreat is between 4:00 - 6:00 p.m. on &#123;&#123;&#36; participant-&gt;retreat_start_date-&gt;format(&apos;l F j, Y&apos;) &#125;&#125;.
            		Dinner will be served from 6:00 - 7:00 p.m. When you arrive, please come to Campion Hall to receive your room key and retreat packet.
            		Below are some possible suggestions regarding what to bring.
            		Some frequently asked questions can be found on our FAQs webpage but feel free to call or email should you need more information.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            7 => [
                'title' => 'event-confirmation',
                'label' => 'confirm',
                'locale' => 'en_US',
                'snippet' =>
                   "Kindly <a href=&quot;&#123;&#123; url(&apos;intercept/&apos;.&#36;encodedUrl ) &#125;&#125;&quot;>click here to confirm your attendance</a>.
           		If your plans have changed kindly let us know by calling us at 940-321-6020 or emailing us at registration@montserratretreat.org.
           		We would be happy to help you reschedule your retreat.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            8 => [
                'title' => 'event-confirmation',
                'label' => 'notices',
                'locale' => 'en_US',
                'snippet' =>
                      "		<strong><u>Special COVID-19 Considerations:</u></strong><br>
                      		• First and foremost, <strong><u>stay home if you are sick in any way</u>.</strong><br>
                      		• For those 65 and older or have any health issues that might put one <u>at a higher risk</u> from COVID-19, consider staying home. <br>
                      		• Everyone should have a mask on when leaving their room. Masks are always to remain on, indoors and outdoors, until returning to your room. <br>
                      		• If you begin to feel sick while you are here immediately call the Innkeeper at 940-220-9168. <br>
                      		• Individuals are always to remain at least six feet apart, both indoors and outdoors.<br>
                      		• Wash your hands frequently <br>
                      		• Use hand sanitizer frequently. Hand sanitizer dispensers are located near the entrance of each building <br>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            9 => [
                'title' => 'event-confirmation',
                'label' => 'signature',
                'locale' => 'en_US',
                'snippet' =>
                     "In the Lord,<br><br>
             		Fr. Tony Raushchuber, S.J.<br>
             		Director<br><br>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            10 => [
                'title' => 'event-confirmation',
                'label' => 'provided',
                'locale' => 'en_US',
                'snippet' =>
                    "What is provided:<br>
            		• All meals, snacks and beverages<br>
            		• Bed linens, pillows, towels, and washcloths<br>
            		• Each room has a private bath and individually controlled cooling/heating units<br><br>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            11 => [
                'title' => 'event-confirmation',
                'label' => 'bring',
                'locale' => 'en_US',
                'snippet' =>
                   "What to bring:<br>
               		• <strong>In light of COVID-19, you are expected to bring a <u>face mask</u></strong><br>
               		• Personal medicines, toiletries and hairdryer<br>
               		• Comfortable, casual clothes and walking shoes<br>
               		• A pen, journal or notebook<br>
               		• A water bottle for taking beverages out of the dining hall<br>
               		• All buildings are air-conditioned in the summer, so a light jacket or sweater may be helpful<br>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            12 => [
                'title' => 'birthday',
                'label' => 'footer',
                'locale' => 'en_US',
                'snippet' =>
                    "<h2>
                        <a href=&quot;https://www.montserratretreat.org&quot; target=&quot;_blank&quot;>
                            <img src=&quot;https://i.imgur.com/c5kmJcn.jpg&quot; style=&quot;display:block;margin-left:auto;margin-right:auto&quot; width=&quot;139&quot; height=&quot;44&quot;>
                        </a>
                    </h2>
                    <p style=&quot;text-align:center&quot;>
                        <span style=&quot;font-size:8pt&quot;><br>
                        <i>
                            <a href=&quot;tel:(940) 321-6020&quot; value=&quot;+19403216020&quot; target=&quot;_blank&quot;>940-321-6020</a> .
                            <a href=&quot;https://www.montserratretreat.org/&quot; target=&quot;_blank&quot;>montserratretreat.org</a>
                        </i>
                        </span>
                    </p>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            13 => [
                'title' => 'birthday',
                'label' => 'quote',
                'locale' => 'en_US',
                'snippet' =>
                   "<p style=&quot;text-align:center&quot;>
                       <b>&quot;I have told you this <br>
                           so that my joy may be in you <br>
                           and your joy may be complete!&quot; <br>
                           <span style=&quot;font-size:8pt&quot;>
                               John 15:11
                           </span>
                       </b>
                   </p>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            14 => [
                'title' => 'birthday',
                'label' => 'message',
                'locale' => 'en_US',
                'snippet' =>
                   "<p style=&quot;text-align:center&quot;>
                        <span style=&quot;font-size:10pt&quot;>
                            The Jesuits and Staff of <br>
                            Montserrat Jesuit Retreat House <br>
                            wish you many joy-filled birthday blessings. <br><br>
                            May your arms and heart <br>
                            open wide to receive all <br>
                            of God&apos;s good gifts.
                        </span>
                    </p>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            15 => [
                'title' => 'birthday',
                'label' => 'picture',
                'locale' => 'en_US',
                'snippet' =>
                   "<h2>
                       <img src=&quot;https://polanco.montserratretreat.org/images/happy_birthday.jpg&quot; style=&quot;display:block;margin-left:auto;margin-right:auto&quot; width=&quot;350&quot; height=&quot;403&quot;>
                   </h2>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            16 => [
                'title' => 'birthday',
                'label' => 'footer',
                'locale' => 'sp_SP',
                'snippet' =>
                    "<h2>
                        <a href=&quot;https://www.montserratretreat.org&quot; target=&quot;_blank&quot;>
                            <img src=&quot;https://i.imgur.com/c5kmJcn.jpg&quot; style=&quot;display:block;margin-left:auto;margin-right:auto&quot; width=&quot;139&quot; height=&quot;44&quot;>
                        </a>
                    </h2>
                    <p style=&quot;text-align:center&quot;>
                        <span style=&quot;font-size:8pt&quot;><br>
                        <i>
                            <a href=&quot;tel:(940) 321-6020&quot; value=&quot;+19403216020&quot; target=&quot;_blank&quot;>940-321-6020</a> .
                            <a href=&quot;https://www.montserratretreat.org/&quot; target=&quot;_blank&quot;>montserratretreat.org</a>
                        </i>
                        </span>
                    </p>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            17 => [
                'title' => 'birthday',
                'label' => 'quote',
                'locale' => 'sp_SP',
                'snippet' =>
                   "<p style=&quot;text-align:center&quot;>
                       <b>&quot;¡Les he dicho esto<br />
                       para que tengan mi alegría<br />
                       y así su alegría sea completa!<br />
                       <span style=&quot;font-size:8pt&quot;>
                               Juan 15:11
                       </span>
                       </b>
                   </p>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            18 => [
                'title' => 'birthday',
                'label' => 'message',
                'locale' => 'sp_SP',
                'snippet' =>
                   "<p style=&quot;text-align:center&quot;>
                        <span style=&quot;font-size:10pt&quot;>
                            Los jesuitas y todos de la comunidad de la<br>
                            Casa de Retiros de Montserrat <br>
                            esperen que su corazón se desborda de alegría. <br>
                            Que sus brazos y corazón  <br>
                            se mantengan abiertos para recibir todo <br>
                            lo que Dios le regale. <br>
                        </span>
                    </p>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            19 => [
                'title' => 'birthday',
                'label' => 'picture',
                'locale' => 'sp_SP',
                'snippet' =>
                   "<h2>
                       <img src=&quot;https://polanco.montserratretreat.org/images/happy_birthday.jpg&quot; style=&quot;display:block;margin-left:auto;margin-right:auto&quot; width=&quot;350&quot; height=&quot;403&quot;>
                   </h2>",
                'created_at' => now(),
                'updated_at' => now(),
            ],
    ]);
    }
}
