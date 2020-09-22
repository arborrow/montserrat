<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SnippetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('snippets')->delete();

        DB::table('snippets')->insert([
            0 => [
                'title' => 'agc_acknowledge',
                'label' => 'board',
                'locale' => 'en_US',
                'snippet' => 'Peter Bowler <br />
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
                    Fr. Thompson <br /><br />',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            1 => [
                'title' => 'agc_acknowledge',
                'label' => 'jesuits',
                'locale' => 'en_US',
                'snippet' => 'Fr. Rauschuber, S.J.<br />
                    Fr. Gonzales, S.J.<br />
                    Fr. Joseph, S.J.<br />
                    Fr. Vo, S.J.<br />',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            2 => [
                'title' => 'agc_acknowledge',
                'label' => 'letter',
                'locale' => 'en_US',
                'snippet' => 'Dear &#123;&#123;&#36;donation->contact->agc_household_name&#125;&#125;,
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
                    <br />',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            3 => [
                'title' => 'agc_acknowledge',
                'label' => '501c3',
                'locale' => 'en_US',
                'snippet' => 'Montserrat Jesuit Retreat House is a ministry of the Society of Jesus UCS Province
                    <br />
                    No goods or services have been provided to the donor.
                    <br />
                    Your donation is deductible to the extent allowed by law.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            4 => [
                'title' => 'agc_acknowledge',
                'label' => 'footer',
                'locale' => 'en_US',
                'snippet' => '<table style="width:100%; margin:auto;">
                        <tr>
                            <td style="width:33%; margin:auto; text-align:center">PO Box 1390</td>
                            <td style="width:33%; margin:auto; text-align:center">600 N. Shady Shores Dr</td>
                            <td style="width:33%; margin:auto; text-align:center">Lake Dallas, TX 75065<td>
                        </tr>
                            <tr>
                            <td style="text-align:center">(940) 321-6020</td>
                            <td> </td>
                            <td style="text-align:center">montserratretreat.org </td>

                        </tr>
                    </table>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            5 => [
                'title' => 'event-confirmation',
                'label' => 'welcome',
                'locale' => 'en_US',
                'snippet' => 'We are praying for you as your upcoming retreat approaches.
                    You will find a beautiful campus, made holy by the thousands who have prayed here, that is both hospitable and restorative.
                    We greatly look forward to welcoming and accompanying you during the retreat.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            6 => [
                'title' => 'event-confirmation',
                'label' => 'checkin',
                'locale' => 'en_US',
                'snippet' => 'Check-in for your retreat is between 4:00 - 6:00 p.m. on &#123;&#123;&#36;participant-&gt;retreat_start_date-&gt;format(&apos;l F j, Y&apos;) &#125;&#125;.
            		Dinner will be served from 6:00 - 7:00 p.m. When you arrive, please come to Campion Hall to receive your room key and retreat packet.
            		Below are some possible suggestions regarding what to bring.
            		Some frequently asked questions can be found on our FAQs webpage but feel free to call or email should you need more information.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            7 => [
                'title' => 'event-confirmation',
                'label' => 'confirm',
                'locale' => 'en_US',
                'snippet' => 'Kindly <a href=&quot;&#123;&#123; url(&apos;intercept/&apos;.&#36;encodedUrl ) &#125;&#125;&quot;>click here to confirm your attendance</a>.
           		If your plans have changed kindly let us know by calling us at 940-321-6020 or emailing us at registration@montserratretreat.org.
           		We would be happy to help you reschedule your retreat.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            8 => [
                'title' => 'event-confirmation',
                'label' => 'notices',
                'locale' => 'en_US',
                'snippet' => '		<strong><u>Special COVID-19 Considerations:</u></strong><br>
                      		• First and foremost, <strong><u>stay home if you are sick in any way</u>.</strong><br>
                      		• For those 65 and older or have any health issues that might put one <u>at a higher risk</u> from COVID-19, consider staying home. <br>
                      		• Everyone should have a mask on when leaving their room. Masks are always to remain on, indoors and outdoors, until returning to your room. <br>
                      		• If you begin to feel sick while you are here immediately call the Innkeeper at 940-220-9168. <br>
                      		• Individuals are always to remain at least six feet apart, both indoors and outdoors.<br>
                      		• Wash your hands frequently <br>
                      		• Use hand sanitizer frequently. Hand sanitizer dispensers are located near the entrance of each building <br>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            9 => [
                'title' => 'event-confirmation',
                'label' => 'signature',
                'locale' => 'en_US',
                'snippet' => 'In the Lord,<br><br>
             		Fr. Tony Raushchuber, S.J.<br>
             		Director<br><br>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            10 => [
                'title' => 'event-confirmation',
                'label' => 'provided',
                'locale' => 'en_US',
                'snippet' => 'What is provided:<br>
            		• All meals, snacks and beverages<br>
            		• Bed linens, pillows, towels, and washcloths<br>
            		• Each room has a private bath and individually controlled cooling/heating units<br><br>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            11 => [
                'title' => 'event-confirmation',
                'label' => 'bring',
                'locale' => 'en_US',
                'snippet' => 'What to bring:<br>
               		• <strong>In light of COVID-19, you are expected to bring a <u>face mask</u></strong><br>
               		• Personal medicines, toiletries and hairdryer<br>
               		• Comfortable, casual clothes and walking shoes<br>
               		• A pen, journal or notebook<br>
               		• A water bottle for taking beverages out of the dining hall<br>
               		• All buildings are air-conditioned in the summer, so a light jacket or sweater may be helpful<br>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            12 => [
                'title' => 'birthday',
                'label' => 'footer',
                'locale' => 'en_US',
                'snippet' => '<h2>
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
                    </p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            13 => [
                'title' => 'birthday',
                'label' => 'quote',
                'locale' => 'en_US',
                'snippet' => '<p style=&quot;text-align:center&quot;>
                       <b>&quot;I have told you this <br>
                           so that my joy may be in you <br>
                           and your joy may be complete!&quot; <br>
                           <span style=&quot;font-size:8pt&quot;>
                               John 15:11
                           </span>
                       </b>
                   </p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            14 => [
                'title' => 'birthday',
                'label' => 'message',
                'locale' => 'en_US',
                'snippet' => '<p style=&quot;text-align:center&quot;>
                        <span style=&quot;font-size:10pt&quot;>
                            The Jesuits and Staff of <br>
                            Montserrat Jesuit Retreat House <br>
                            wish you many joy-filled birthday blessings. <br><br>
                            May your arms and heart <br>
                            open wide to receive all <br>
                            of God&apos;s good gifts.
                        </span>
                    </p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            15 => [
                'title' => 'birthday',
                'label' => 'picture',
                'locale' => 'en_US',
                'snippet' => '<h2>
                       <img src=&quot;https://polanco.montserratretreat.org/images/happy_birthday.jpg&quot; style=&quot;display:block;margin-left:auto;margin-right:auto&quot; width=&quot;350&quot; height=&quot;403&quot;>
                   </h2>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            16 => [
                'title' => 'birthday',
                'label' => 'footer',
                'locale' => 'es_ES',
                'snippet' => '<h2>
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
                    </p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            17 => [
                'title' => 'birthday',
                'label' => 'quote',
                'locale' => 'es_ES',
                'snippet' => '<p style=&quot;text-align:center&quot;>
                       <b>&quot;¡Les he dicho esto<br />
                       para que tengan mi alegría<br />
                       y así su alegría sea completa!<br />
                       <span style=&quot;font-size:8pt&quot;>
                               Juan 15:11
                       </span>
                       </b>
                   </p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            18 => [
                'title' => 'birthday',
                'label' => 'message',
                'locale' => 'es_ES',
                'snippet' => '<p style=&quot;text-align:center&quot;>
                        <span style=&quot;font-size:10pt&quot;>
                            Los jesuitas y todos de la comunidad de la<br>
                            Casa de Retiros de Montserrat <br>
                            esperen que su corazón se desborda de alegría. <br>
                            Que sus brazos y corazón  <br>
                            se mantengan abiertos para recibir todo <br>
                            lo que Dios le regale. <br>
                        </span>
                    </p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            19 => [
                'title' => 'birthday',
                'label' => 'picture',
                'locale' => 'es_ES',
                'snippet' => '<h2>
                       <img src=&quot;https://polanco.montserratretreat.org/images/happy_birthday.jpg&quot; style=&quot;display:block;margin-left:auto;margin-right:auto&quot; width=&quot;350&quot; height=&quot;403&quot;>
                   </h2>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            20 => [
                'title' => 'agc_acknowledge',
                'label' => 'board',
                'locale' => 'es_ES',
                'snippet' => 'Peter Bowler <br />
                    <i>Presidente</i> <br />
                    <br />
                    Mark Vehslage <br />
                    <i>Tesorero</i> <br />
                    <br />
                    Mary Del Olmo <br />
                    <i>Secretaria</i> <br />
                    <br />
                    Paul Pederson <br />
                    Richard Rolland <br />
                    Fr. Thompson <br /><br />',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            21 => [
                'title' => 'agc_acknowledge',
                'label' => 'jesuits',
                'locale' => 'es_ES',
                'snippet' => 'P. Rauschuber, S.J.<br />
                    P. Gonzales, S.J.<br />
                    P. Joseph, S.J.<br />
                    P. Vo, S.J.<br />',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            22 => [
                'title' => 'agc_acknowledge',
                'label' => 'letter',
                'locale' => 'es_ES',
                'snippet' => 'Querida familia &#123;&#123;&#36;donation->contact->last_name&#125;&#125;,<br />
                    <br />
                    Jesús nos promete que la puerta estará abierta para aquellos que piden, buscan y llaman. Nosotros tocamos sobre su puerta y usted respondió generosamente.
                    Agradecemos su donación de &#36;&#123;&#123;number_format(&#36;donation->payments_paid,2)&#125;&#125; para &quot;&#123;&#123;&#36;donation->donation_description&#125;&#125;&quot; recibida en &#123;&#123;&#36;donation->donation_date_es&#125;&#125; para apoyar Montserrat.
                    Tengan por seguro que se le dará un buen uso.<br />
                    <br />
                    La gente necesita un lugar para descansar y espacio para orar.
                    Montserrat existe para ayudarlos reconocer la gracia de todas las bendiciones que solo vienen de Dios.
                    Por este motivo, no descansamos hasta que la casa esté llena.
                    Su donación a la Campaña Anual de Donaciones nos ayuda seguir creciendo y poder seguir ofreciendo un espacio de oración para todos los que estén necesitados y que desean profundizar su relación con Dios.
                    Gracias a usted, podemos seguir apoyando al pueblo de Dios.<br />
                    <br />
                    Usted y su familia serán recordados diariamente en nuestras oraciones y misas en Montserrat.
                    San Ignacio de Loyola ofreció esta bendición a sus amigos, por lo que ahora se la ofrecemos a ustedes: &quot;Que siempre le complazca al Señor recompensarlo con sus consuelos sagrados, sus bendiciones espirituales y su paz eterna.&quot;<br />
                    <br />
                    Paz,<br />
                    <br />
                    <br />
                    P. Anthony Rauschuber, S.J.<br />
                    Director <br />',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            23 => [
                'title' => 'agc_acknowledge',
                'label' => '501c3',
                'locale' => 'es_ES',
                'snippet' => 'La casa jesuita de retiros de Montserrat es un ministerio de la Sociedad de Jesús, la Provincia de UCS.<br />
                    No se han proporcionado bienes o servicios al donante.<br />
                    Su donación es deducible en la medida en que la ley lo permita.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            24 => [
                'title' => 'agc_acknowledge',
                'label' => 'footer',
                'locale' => 'es_ES',
                'snippet' => '<table style="width:100%; margin:auto;">
                        <tr>
                            <td style="width:33%; margin:auto; text-align:center">PO Box 1390</td>
                            <td style="width:33%; margin:auto; text-align:center">600 N. Shady Shores Dr</td>
                            <td style="width:33%; margin:auto; text-align:center">Lake Dallas, TX 75065<td>
                        </tr>
                            <tr>
                            <td style="text-align:center">(940) 321-6020</td>
                            <td> </td>
                            <td style="text-align:center">montserratretreat.org </td>

                        </tr>
                    </table>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            25 => [
                'title' => 'event-confirmation',
                'label' => 'welcome',
                'locale' => 'es_ES',
                'snippet' => 'Estamos rezando por usted durante este tiempo de preparación para el retiro que se acerca.
        			Encontrará vistas hermosas y tierra santa sanctificada por las oraciones de la gran cantidad de personas que han rezado aqui en Montserrat.
        			Esperamos la oportunidad de hospedarle para una experiencia de renovación espiritual.
        			Estamos encantados y agradecidos de que usted haga que la tierra de Montserrat sea sagrada con sus oraciones.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            26 => [
                'title' => 'event-confirmation',
                'label' => 'checkin',
                'locale' => 'es_ES',
                'snippet' => 'Le esperamos de las 4:00 a las 6:00 de la tarde el &#123;&#123; &#36;participant->retreat_start_date_es &#125;&#125; para registrarse.
                    Empezamos serviendo la cena de las 6:00 de la tarde hasta las 7:00.
                    Al llegar, favor de reportarse a la sala de recibo para recibir un folleto de materiales para el retiro y la llave para su recámara.
                    Abajo anotamos unas surgerencias de lo que ofrecemos, lo que va a necesitar para el retiro y lo que no va a necesitar.
                    También hay una página de web de las preguntas más frecuentes.
                    Si tiene alguna duda favor de llamarnos a la oficina (940-321-6020) o mandar un correo-electrónico para más información.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            27 => [
                'title' => 'event-confirmation',
                'label' => 'confirm',
                'locale' => 'es_ES',
                'snippet' => 'Favor de tomar un momento y <a href=&quot;&#123;&#123; url(&apos;intercept/&apos;.&#36;encodedUrl ) &#125;&#125;&quot;>hacer clic para confirmar que va a asistir al retiro</a>.
                   Si cambian sus planes, por favor avísanos lo antes posible por teléfono (940-321-6020) o por correo-electrónico (registrar@montserratretreat.org), ya que hay una lista de espera para el retiro y queremos acomodar a todos los que quieren venir.
                   Podemos ayudarle a cambiar la fecha para otro retiro más conveniente.
                   Esperamos darle la bienvenida pronto.
                   Hasta entonces, oremos los unos por los otros.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            28 => [
                'title' => 'event-confirmation',
                'label' => 'notices',
                'locale' => 'es_ES',
                'snippet' => '<strong><u>Coronavirus: Tome en cuenta las siguientes consideraciones:</u></strong><br>
                        • <strong><u>Quedese en casa si está enferm@ de cualquier forma</u></strong> <br>
                        • Si tiene más de 65 años de edad o preocupaciones de salud que le pone en <u>alto riesgo</u> del Coronavirus debe consider quedarse en casa.<br>
                        • Todos deben usar una cubierta de tela (o sea una máscara de proteccíon) al salir de su habitación. Sigue usando la máscara (adentro y afuera) hasta que regrese a su habitación. <br>
                        • Si comienza a sentirse enfermo, llame de inmediato al Asistente al 940-220-9168. <br>
                        • Las personas deben permanecer separadas por lo menos seis pies, tanto en lugares interiores como en los exteriores. <br>
                        • Lávese las manos con frecuencia. <br>
                        • Use desinfectante de manos con frecuencia. Los dispensadores de desinfectante para las manos están ubicados cerca de la entrada de cada edificio.<br>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            29 => [
                'title' => 'event-confirmation',
                'label' => 'signature',
                'locale' => 'es_ES',
                'snippet' => 'Paz - Padre Tony Raushchuber, S.J., Director<br>
                     director@montserratretreat.org <br>
                     940-321-6020<br>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            30 => [
                'title' => 'event-confirmation',
                'label' => 'provided',
                'locale' => 'es_ES',
                'snippet' => 'Lo que ofrecemos:<br>
        			• Todas las comidas, bocadillos y refrescos<br>
        			• Toallas, sábanas, y almohadas<br>
        			• Cada recamara tiene baño privado y aire acondicionado <br>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            31 => [
                'title' => 'event-confirmation',
                'label' => 'bring',
                'locale' => 'es_ES',
                'snippet' => 'Lo que debe traer: <br>
                   • <strong>Considerando la realidad del Coronavirus, esperamos que traiga su propia <u>cubierta de tela (o sea máscara de proteccíon)</u></strong> <br>
                   • Medicamentos personales, artículos de tocador y secadora de pelo <br>
                   • Ropa cómoda y casual y zapatos cómodos <br>
                   • Un cuaderno o páginas para escribir sus propias oraciones, reflexiones, notas o experiencias <br>
                   • Cada habitación tiene una Biblia, pero usted puede traer la suya también<br>
                   <br>
                   Para dejar en casa: <br>
                   • Computadoras, tabletas, etc. - Poderse desconectar de lo rutinario es importante para su experiencia durante el retiro.<br>
                   • Teléfonos: Le pedimos que apague y guarde su teléfono una vez que llegue a Montserrat. Por favor, proporcione este número de teléfono a quienes lo necesiten para fines de contacto de emergencia: 940-220-9168. El personal de Montserrat le notificará si recibe un mensaje.<br>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            32 => [
                'title' => 'agc_acknowledge',
                'label' => 'board',
                'locale' => 'en_US',
                'snippet' => 'Peter Bowler <br />
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
                    Fr. Thompson <br /><br />',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            33 => [
                'title' => 'agc_acknowledge',
                'label' => 'jesuits',
                'locale' => 'en_US',
                'snippet' => 'Fr. Rauschuber, S.J.<br />
                    Fr. Gonzales, S.J.<br />
                    Fr. Joseph, S.J.<br />
                    Fr. Vo, S.J.<br />',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            34 => [
                'title' => 'agc_acknowledge',
                'label' => 'letter',
                'locale' => 'en_US',
                'snippet' => '@if ($payments->isEmpty())
                <p>It appears that our records do not show any donations made to Montserrat from {{ $start_date }} to {{ $end_date }}.</p>
                @else
                    <p>Thank you for your support of Montserrat Jesuits Retreat House. Below is a listing of the donations received.</p>
                    <table class="payments" style="width: 100%; font-size:10pt; font-family:montserrat; border: solid 0.5pt; border-collapse: collapse; ">
                        <caption>
                            <strong>Donations from {{ $start_date->format('m-d-Y') }} to {{ $end_date->format('m-d-Y') }}</strong>
                        </caption>
                        <thead>
                            <tr>
                                <th style="border: solid 1px; padding:5px;">Date</th>
                                <th style="border: solid 1px; padding:5px;">Description</th>
                                <th style="border: solid 1px; padding:5px;">Donation Amount</th>
                                <th style="border: solid 1px; padding:5px;">Method</th>
                                <th style="border: solid 1px; padding:5px;">Retreat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td style="border: solid 1px; padding:5px;">{{ $payment->payment_date->format('M d, Y') }}</td>
                                    <td style="border: solid 1px; padding:5px;">{{ $payment->donation->donation_description ?? 'Unspecified' }} </td>
                                    <td style="border: solid 1px; padding:5px; text-align: right;">${{ payment->payment_amount }}</td>
                                    <td style="border: solid 1px; padding:5px;">{{ $payment->payment_description }} {{ $payment->ccnumber ?? $payment->cknumber}}</td>
                                    <td style="border: solid 1px; padding:5px;">{{ $payment->donation->retreat->title ?? 'N/A'}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                <br />
                @endIf
                Peace,<br />',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            36 => [
                'title' => 'agc_acknowledge',
                'label' => '501c3',
                'locale' => 'en_US',
                'snippet' => 'Montserrat Jesuit Retreat House is a ministry of the Society of Jesus UCS Province
                    <br />
                    Your donation is deductible to the extent allowed by law.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            37 => [
                'title' => 'agc_acknowledge',
                'label' => 'footer',
                'locale' => 'en_US',
                'snippet' => '<table style="width:100%; margin:auto;">
                        <tr>
                            <td style="width:33%; margin:auto; text-align:center">PO Box 1390</td>
                            <td style="width:33%; margin:auto; text-align:center">600 N. Shady Shores Dr</td>
                            <td style="width:33%; margin:auto; text-align:center">Lake Dallas, TX 75065<td>
                        </tr>
                            <tr>
                            <td style="text-align:center">(940) 321-6020</td>
                            <td> </td>
                            <td style="text-align:center">montserratretreat.org </td>

                        </tr>
                    </table>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
    ]);
    }
}
