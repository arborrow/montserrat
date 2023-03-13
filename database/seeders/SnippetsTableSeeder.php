<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SnippetsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run(): void
    {
        \DB::table('snippets')->delete();

        \DB::table('snippets')->insert([
            0 => [
                'id' => 1,
                'title' => 'agc_acknowledge',
                'label' => 'board',
                'locale' => 'en_US',
                'snippet' => 'Peter Bowler <br />
<i>President</i> <br />
<br />
Danny Monistere <br />
<i>Vice President</i> <br />
<br />
Jerry Sanders <br />
<i>Secretary </i> <br />
<br />
Neitheva Calta <br /> 
Leslie Hever <br />
Theresa Motter<br />
Michael Ogden<br />
Mary Del Olmo<br />
Deacon John O\'Leary',
                'created_at' => '2020-09-04 15:40:36',
                'updated_at' => '2022-03-25 17:07:01',
                'deleted_at' => null,
            ],
            1 => [
                'id' => 2,
                'title' => 'agc_acknowledge',
                'label' => 'jesuits',
                'locale' => 'en_US',
                'snippet' => 'Fr. Rauschuber, S.J.<br />
Fr. French, S.J.<br />
Fr. Ruiz, S.J.<br />
Fr. Vo, S.J.',
                'created_at' => '2020-09-04 15:40:36',
                'updated_at' => '2022-11-22 17:42:49',
                'deleted_at' => null,
            ],
            2 => [
                'id' => 3,
                'title' => 'agc_acknowledge',
                'label' => 'letter',
                'locale' => 'en_US',
                'snippet' => 'Dear {{$donation->contact->agc_household_name}},<br />
<br />
Jesus promises the door will be opened to those who ask, seek, and knock.
We knocked on your door and you generously answered. Thank you for your gift of ${{number_format($donation->payments_paid,2)}} for {{$donation->donation_description}} supporting Montserrat Jesuit Retreat House. We promise you that it will be put to good use.<br />
<br />
People need a place to rest and space to pray. At Montserrat, we never get tired of encouraging good people to open their hearts to God\'s generous graces. 
Your gift to the Annual Giving Campaign helps keep Montserrat growing and available to all who need prayer and counsel for their life in Christ. 
Because of you we can continue to minister to God\'s people.<br />
<br />
Thank you again, and know you are remembered daily in prayers and masses at Montserrat. 
St. Ignatius offered this blessing to his friends and so we now offer it to you: "May it ever please the Lord to recompense and repay you with his most holy consolations and spiritual blessings and eternal peace."<br />
<br />
Peace,<br />
<br />
<br />
<br />
Fr. Anthony Rauschuber, S.J.<br />
Director',
                'created_at' => '2020-09-04 15:40:36',
                'updated_at' => '2020-09-05 22:20:35',
                'deleted_at' => null,
            ],
            3 => [
                'id' => 4,
                'title' => 'agc_acknowledge',
                'label' => '501c3',
                'locale' => 'en_US',
                'snippet' => 'Montserrat Jesuit Retreat House is a ministry of the Society of Jesus UCS Province
<br />
No goods or services have been provided to the donor.
<br />
Your donation is deductible to the extent allowed by law.',
                'created_at' => '2020-09-04 15:40:36',
                'updated_at' => '2020-09-04 15:40:36',
                'deleted_at' => null,
            ],
            4 => [
                'id' => 5,
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
                'created_at' => '2020-09-04 15:40:36',
                'updated_at' => '2020-09-04 15:40:36',
                'deleted_at' => null,
            ],
            5 => [
                'id' => 6,
                'title' => 'event-confirmation',
                'label' => 'welcome',
                'locale' => 'en_US',
                'snippet' => 'We are praying for you as your upcoming retreat approaches.
You will find a beautiful campus, made holy by the thousands who have prayed here, that is both hospitable and restorative.
We greatly look forward to welcoming and accompanying you during the retreat.   Please note that you will be attending an <strong>Ignatian Silent Retreat.</strong><br /> <br />
The safety of our retreatants and staff is our highest priority. We have put in place the following procedures to ensure the safest environment possible for you to relax and enjoy your retreat.',
                'created_at' => '2020-09-04 15:40:36',
                'updated_at' => '2022-11-03 17:01:12',
                'deleted_at' => null,
            ],
            6 => [
                'id' => 7,
                'title' => 'event-confirmation',
                'label' => 'checkin',
                'locale' => 'en_US',
                'snippet' => 'Check-in for your retreat is between 4:00 - 6:00 p.m. on {{$participant->retreat_start_date->format(&apos;l F j, Y&apos;) }}.
When you arrive, please come to Campion Hall to receive your room key and retreat packet.',
                'created_at' => '2020-09-04 15:40:36',
                'updated_at' => '2020-10-07 20:07:55',
                'deleted_at' => null,
            ],
            7 => [
                'id' => 8,
                'title' => 'event-confirmation',
                'label' => 'confirm',
                'locale' => 'en_US',
                'snippet' => 'Kindly <a href="{{ url(&apos;intercept/&apos;.$encodedUrl ) }}">click here to confirm your attendance</a>.
If your plans have changed kindly let us know by calling us at 940-321-6020 or emailing us at registration@montserratretreat.org.
We would be happy to help you reschedule your retreat.  Visit our <a href="https://montserratretreat.org/retreat-frequently-asked-questions">Frequently Asked Questions section</a> to know more 
information about the retreat.',
                'created_at' => '2020-09-04 15:40:36',
                'updated_at' => '2022-11-03 16:46:48',
                'deleted_at' => null,
            ],
            8 => [
                'id' => 9,
                'title' => 'event-confirmation',
                'label' => 'notices',
                'locale' => 'en_US',
                'snippet' => '<strong><u>Special COVID-19 Considerations:</u></strong><br>
•  The personal use of a face mask is optional.<br>
• If you begin to feel sick in any way while you are here immediately call the Innkeeper at 972-512-8214. <br>
•  Wash your hands frequently <br>
•  Use hand sanitizer frequently. Hand sanitizer dispensers are located near the entrance of each building <br>
•  Please be reminded, only registered retreatants are authorized on campus during retreat hours during the pandemic <br>',
                'created_at' => '2020-09-04 15:40:36',
                'updated_at' => '2022-05-03 19:48:04',
                'deleted_at' => null,
            ],
            9 => [
                'id' => 10,
                'title' => 'event-confirmation',
                'label' => 'signature',
                'locale' => 'en_US',
                'snippet' => 'In the Lord,<br><br>
Fr. Tony Raushchuber, S.J.<br>
Director<br><br>',
                'created_at' => '2020-09-04 15:40:36',
                'updated_at' => '2020-09-04 15:40:36',
                'deleted_at' => null,
            ],
            10 => [
                'id' => 11,
                'title' => 'event-confirmation',
                'label' => 'provided',
                'locale' => 'en_US',
                'snippet' => null,
                'created_at' => '2020-09-04 15:40:36',
                'updated_at' => '2020-10-07 20:16:17',
                'deleted_at' => null,
            ],
            11 => [
                'id' => 12,
                'title' => 'event-confirmation',
                'label' => 'bring',
                'locale' => 'en_US',
                'snippet' => '<strong><u>What to bring:</u></strong><br>
• Personal medicines, toiletries, shampoo and hairdryer<br>
• Do not need to bring towels, or bar soap<br>
• Comfortable, casual clothes and walking shoes<br>
• A pen, journal or notebook<br>
• A water bottle for taking water out of the dining hall<br>
• All buildings are air-conditioned in the summer, so a light jacket or sweater may be helpful<br>',
                'created_at' => '2020-09-04 15:40:36',
                'updated_at' => '2022-11-03 16:51:23',
                'deleted_at' => null,
            ],
            12 => [
                'id' => 13,
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
                'created_at' => '2020-09-04 15:40:36',
                'updated_at' => '2020-09-04 15:40:36',
                'deleted_at' => null,
            ],
            13 => [
                'id' => 14,
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
                'created_at' => '2020-09-04 15:40:36',
                'updated_at' => '2020-09-04 15:40:36',
                'deleted_at' => null,
            ],
            14 => [
                'id' => 15,
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
                'created_at' => '2020-09-04 15:40:36',
                'updated_at' => '2020-09-04 15:40:36',
                'deleted_at' => null,
            ],
            15 => [
                'id' => 16,
                'title' => 'birthday',
                'label' => 'picture',
                'locale' => 'en_US',
                'snippet' => '<h2>
<img src=&quot;https://polanco.montserratretreat.org/images/happy_birthday.jpg&quot; style=&quot;display:block;margin-left:auto;margin-right:auto&quot; width=&quot;350&quot; height=&quot;403&quot;>
</h2>',
                'created_at' => '2020-09-04 15:40:36',
                'updated_at' => '2020-09-04 15:40:36',
                'deleted_at' => null,
            ],
            16 => [
                'id' => 17,
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
                'created_at' => '2020-09-04 15:40:36',
                'updated_at' => '2020-09-04 15:40:36',
                'deleted_at' => null,
            ],
            17 => [
                'id' => 18,
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
                'created_at' => '2020-09-04 15:40:36',
                'updated_at' => '2020-09-04 15:40:36',
                'deleted_at' => null,
            ],
            18 => [
                'id' => 19,
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
                'created_at' => '2020-09-04 15:40:36',
                'updated_at' => '2020-09-04 15:40:36',
                'deleted_at' => null,
            ],
            19 => [
                'id' => 20,
                'title' => 'birthday',
                'label' => 'picture',
                'locale' => 'es_ES',
                'snippet' => '<h2>
<img src=&quot;https://polanco.montserratretreat.org/images/happy_birthday.jpg&quot; style=&quot;display:block;margin-left:auto;margin-right:auto&quot; width=&quot;350&quot; height=&quot;403&quot;>
</h2>',
                'created_at' => '2020-09-04 15:40:36',
                'updated_at' => '2020-09-04 15:40:36',
                'deleted_at' => null,
            ],
            20 => [
                'id' => 21,
                'title' => 'agc_acknowledge',
                'label' => 'board',
                'locale' => 'es_ES',
                'snippet' => 'Peter Bowler <br />
<i>Presidente</i> <br />
<br />
Danny Monistere <br />
<i>Vicepresidente</i> <br />
<br />
Jerry Sanders <br />
<i>Secretario </i> <br />
<br />
Neitheva Calta <br /> 
Leslie Hever <br />
Theresa Motter<br />
Michael Ogden <br />
Mary Del Olmo <br />
Deacon John O\'Leary',
                'created_at' => '2020-09-04 15:40:36',
                'updated_at' => '2022-03-15 17:06:13',
                'deleted_at' => null,
            ],
            21 => [
                'id' => 22,
                'title' => 'agc_acknowledge',
                'label' => 'jesuits',
                'locale' => 'es_ES',
                'snippet' => 'P. Rauschuber, S.J.<br /> P. French, S.J.<br /> P. Ruiz, S.J.<br /> P. Vo, S.J.',
                'created_at' => '2020-09-04 15:40:36',
                'updated_at' => '2023-01-09 22:21:33',
                'deleted_at' => null,
            ],
            22 => [
                'id' => 23,
                'title' => 'agc_acknowledge',
                'label' => 'letter',
                'locale' => 'es_ES',
                'snippet' => 'Querida familia {{$donation->contact->last_name}},<br />
<br />
Jesús nos promete que la puerta estará abierta para aquellos que piden, buscan y llaman. Nosotros tocamos sobre su puerta y usted respondió generosamente.
Agradecemos su donación de ${{number_format($donation->payments_paid,2)}} para "{{$donation->donation_description}}" recibida en {{$donation->donation_date_es}} para apoyar Montserrat.
Tengan por seguro que se le dará un buen uso.<br />
<br />
La gente necesita un lugar para descansar y espacio para orar.
Montserrat existe para ayudarlos reconocer la gracia de todas las bendiciones que solo vienen de Dios.
Por este motivo, no descansamos hasta que la casa esté llena.
Su donación a la Campaña Anual de Donaciones nos ayuda seguir creciendo y poder seguir ofreciendo un espacio de oración para todos los que estén necesitados y que desean profundizar su relación con Dios.
Gracias a usted, podemos seguir apoyando al pueblo de Dios.<br />
<br />
Usted y su familia serán recordados diariamente en nuestras oraciones y misas en Montserrat.
San Ignacio de Loyola ofreció esta bendición a sus amigos, por lo que ahora se la ofrecemos a ustedes: "Que siempre le complazca al Señor recompensarlo con sus consuelos sagrados, sus bendiciones espirituales y su paz eterna."<br />
<br />
Paz,<br />
<br />
<br />
P. Anthony Rauschuber, S.J.<br />
Director',
                'created_at' => '2020-09-04 15:40:36',
                'updated_at' => '2020-09-05 22:29:36',
                'deleted_at' => null,
            ],
            23 => [
                'id' => 24,
                'title' => 'agc_acknowledge',
                'label' => '501c3',
                'locale' => 'es_ES',
                'snippet' => 'La casa jesuita de retiros de Montserrat es un ministerio de la Sociedad de Jesús, la Provincia de UCS.<br />
No se han proporcionado bienes o servicios al donante.<br />
Su donación es deducible en la medida en que la ley lo permita.',
                'created_at' => '2020-09-04 15:40:36',
                'updated_at' => '2020-09-04 15:40:36',
                'deleted_at' => null,
            ],
            24 => [
                'id' => 25,
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
                'created_at' => '2020-09-04 15:40:36',
                'updated_at' => '2020-09-04 15:40:36',
                'deleted_at' => null,
            ],
            25 => [
                'id' => 26,
                'title' => 'event-confirmation',
                'label' => 'notices',
                'locale' => 'es_ES',
                'snippet' => 'Se aproxima la fecha de nuestro retiro en español, estamos orando por usted durante este tiempo de preparación, esperando nos brinde la oportunidad de recibirlo y pueda vivir una experiencia espiritual en nuestras instalaciones, en donde encontrara vistas hermosas y tierra santificada por las oraciones de tantas personas que hemos hospedado en Monserrat. Estaremos encantados y agradecidos de que usted nos de la oportunidad de guiarlo en esta experiencia sagrada.  Este será un retiro Ignaciano en silencio.<br><br />
La seguridad y la salud de nuestros participantes y del personal es nuestra máxima prioridad en este tiempo de pandemia COVID-19. Hemos implementado algunos procedimientos para garantizar un entorno mas seguro para que se relaje y disfrute de su retiro.',
                'created_at' => '2020-09-04 15:40:36',
                'updated_at' => '2022-11-03 20:33:18',
                'deleted_at' => null,
            ],
            26 => [
                'id' => 27,
                'title' => 'event-confirmation',
                'label' => 'checkin',
                'locale' => 'es_ES',
                'snippet' => 'Su registración será en Campion Hall de 4:00 PM a 6:00pm en donde recibirá un paquete con las indicaciones del retiro la llave de su habitación y los horarios del servicio del comedor. Iniciando con la cena de bienvenida de 6 – 7pm.',
                'created_at' => '2020-09-04 15:40:36',
                'updated_at' => '2020-10-14 16:12:53',
                'deleted_at' => null,
            ],
            27 => [
                'id' => 28,
                'title' => 'event-confirmation',
                'label' => 'confirm',
                'locale' => 'es_ES',
                'snippet' => 'Favor de tomar un momento y <a href="{{ url(&apos;intercept/&apos;.$encodedUrl ) }}">hacer clic para confirmar que va a asistir al retiro</a>.
Si cambian sus planes, por favor avísanos lo antes posible al teléfono (940-321-6020) o por correo-electrónico (registrar@montserratretreat.org).Ya que hay una lista de espera y queremos acomodar a todos los que quieran venir. Con mucho gusto podemos cambiar su fecha de retiro. Visite la <a href="https://montserratretreat.org/retreat-frequently-asked-questions">sección de Preguntas Frecuentes </a>para obtener mayor información acerca de el retiro. Esperamos darle la bienvenida muy pronto, hasta entonces oremos los unos por los otros.',
                'created_at' => '2020-09-04 15:40:36',
                'updated_at' => '2022-11-03 20:48:49',
                'deleted_at' => null,
            ],
            28 => [
                'id' => 29,
                'title' => 'event-confirmation',
                'label' => 'notices',
                'locale' => 'es_ES',
                'snippet' => '<strong><u>Coronavirus: Tome en cuenta las siguientes consideraciones:</u></strong><br>
• El uso personal de una máscara es opcional. <br>
• Si comienza a sentirse mal, de alguna manera, mientras está aquí, llame de inmediato al Asistente al 972.512.8214. <br>
• Lávese las manos con frecuencia. <br>
• Use desinfectante de manos con frecuencia. Los dispensadores de desinfectante para las manos están ubicados cerca de la entrada de cada edificio.<br>
• Durante la pandemia solo las personas participando en el retiro pueden estar en el campus<br>',
                'created_at' => '2020-09-04 15:40:36',
                'updated_at' => '2022-05-03 19:52:25',
                'deleted_at' => null,
            ],
            29 => [
                'id' => 30,
                'title' => 'event-confirmation',
                'label' => 'signature',
                'locale' => 'es_ES',
                'snippet' => 'Paz - Padre Tony Raushchuber, S.J., Director<br>
director@montserratretreat.org <br>
940-321-6020<br>',
                'created_at' => '2020-09-04 15:40:36',
                'updated_at' => '2020-09-04 15:40:36',
                'deleted_at' => null,
            ],
            30 => [
                'id' => 31,
                'title' => 'event-confirmation',
                'label' => 'provided',
                'locale' => 'es_ES',
                'snippet' => '<strong><u>Lo que ofrecemos:</u></strong><br>
• Todas las comidas, bocadillos y refrescos<br>
• Toallas, sábanas, y almohadas<br>
• Cada recamara tiene baño privado y aire acondicionado',
                'created_at' => '2020-09-04 15:40:36',
                'updated_at' => '2021-05-25 21:11:00',
                'deleted_at' => null,
            ],
            31 => [
                'id' => 32,
                'title' => 'event-confirmation',
                'label' => 'bring',
                'locale' => 'es_ES',
                'snippet' => '<strong><u>Lo que debe traer: </u></strong><br>
• Medicamentos personales, artículos de tocador, champú y secadora de pelo <br>
• No es necesario traer toallas ni jabón en barra<br>
• Ropa cómoda y casual y zapatos cómodos <br>
• Un cuaderno o páginas para escribir sus propias oraciones, reflexiones, notas o experiencias <br>
• Cada habitación tiene una Biblia, pero usted puede traer la suya también<br>
<br>
<strong><u>Para dejar en casa:</u></strong><br>
• Computadoras, tabletas, etc. - Poderse desconectar de lo rutinario es importante para su experiencia durante el retiro.<br>
• Teléfonos: Le pedimos que apague y guarde su teléfono una vez que llegue a Montserrat. Por favor, proporcione este número de teléfono a quienes lo necesiten para fines de contacto de emergencia: 972-512-8214. El personal de Montserrat le notificará si recibe un mensaje.<br>',
                'created_at' => '2020-09-04 15:40:36',
                'updated_at' => '2022-05-03 19:51:13',
                'deleted_at' => null,
            ],
            32 => [
                'id' => 33,
                'title' => 'eoy_acknowledgment',
                'label' => 'board',
                'locale' => 'en_US',
                'snippet' => 'Peter Bowler <br />
<i>President</i> <br />
<br />
Danny Monistere <br />
<i>Vice President</i> <br />
<br />
Jerry Sanders <br />
<i>Secretary </i> <br />
<br />
Neitheva Calta <br /> 
Leslie Hever <br />
Theresa Motter<br />
Michael Ogden <br />
Mary Del Olmo <br />
Deacon John O\'Leary',
                'created_at' => null,
                'updated_at' => '2022-03-15 16:56:53',
                'deleted_at' => null,
            ],
            33 => [
                'id' => 34,
                'title' => 'eoy_acknowledgment',
                'label' => 'jesuits',
                'locale' => 'en_US',
                'snippet' => 'Fr. Rauschuber, S.J.<br /> Fr. French, S.J.<br /> Fr. Ruiz, S.J.<br /> Fr. Vo, S.J.',
                'created_at' => null,
                'updated_at' => '2023-01-09 22:17:19',
                'deleted_at' => null,
            ],
            34 => [
                'id' => 35,
                'title' => 'eoy_acknowledgment',
                'label' => 'letter',
                'locale' => 'en_US',
                'snippet' => '@if ($payments->isEmpty())
<p>It appears that our records do not show any donations made to Montserrat from {{ date_format($start_date,"F d, Y") }} to {{ date_format($end_date,"F d, Y") }}.</p>
@else
<p>Thank you for your support of Montserrat Jesuit Retreat House. Below is a listing of the donations received.</p>
<table class="payments" style="width: 100%; font-size:10pt; font-family:montserrat; border: solid 0.5pt; border-collapse: collapse;
">
<caption>
<strong>Donations from {{ $start_date->format(\'m-d-Y\') }} to {{ $end_date->format(\'m-d-Y\') }}</strong>
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

<td style="border: solid 1px; padding:5px;">{{ $payment->payment_date->format(\'M d, Y\') }}</td>
<td style="border: solid 1px; padding:5px;">{{ $payment->donation->donation_description ?? \'Unspecified\' }} </td>
<td style="border: solid 1px; padding:5px; text-align: right;">${{ number_format($payment->payment_amount,2) }}</td>
<td style="border: solid 1px; padding:5px;">{{ $payment->payment_description }} {{ $payment->ccnumber ?? $payment->cknumber}}</td>
<td style="border: solid 1px; padding:5px;">{{ $payment->donation->retreat->title ?? \'N/A\'}}</td>
</tr>
@endforeach

</tbody>

</table>
<br />
@endIf

Peace,<br />',
                'created_at' => null,
                'updated_at' => '2020-12-30 19:38:02',
                'deleted_at' => null,
            ],
            35 => [
                'id' => 36,
                'title' => 'eoy_acknowledgment',
                'label' => '501c3',
                'locale' => 'en_US',
                'snippet' => 'Montserrat Jesuit Retreat House is a ministry of the Society of Jesus UCS Province
<br />
Your donation is deductible to the extent allowed by law.',
                'created_at' => null,
                'updated_at' => '2020-09-22 13:33:44',
                'deleted_at' => null,
            ],
            36 => [
                'id' => 37,
                'title' => 'eoy_acknowledgment',
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
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            37 => [
                'id' => 38,
                'title' => 'event-confirmation',
                'label' => 'For_ the_ Safety',
                'locale' => 'en_US',
                'snippet' => null,
                'created_at' => '2020-10-07 20:02:59',
                'updated_at' => '2020-10-20 20:14:56',
                'deleted_at' => '2020-10-20 20:14:56',
            ],
            38 => [
                'id' => 39,
                'title' => 'event-confirmation',
                'label' => 'Retreat_Attendance',
                'locale' => 'en_US',
                'snippet' => null,
                'created_at' => '2020-10-07 20:03:54',
                'updated_at' => '2020-10-20 20:14:50',
                'deleted_at' => '2020-10-20 20:14:50',
            ],
            39 => [
                'id' => 40,
                'title' => 'squarespace_order_fulfillment',
                'label' => 'body',
                'locale' => 'en_US',
                'snippet' => '{{$order->retreatant->first_name}}, <br /><br />Thank you for registering for {{$order->event->title}}!<br /><br />
Please review the points below to prepare for your retreat:
<ul>
<li>Vegetarian, Gluten Free, and Dairy Free meal options are available if requested prior to the first day of the retreat.  An extended salad bar is also provided. <i>If you are on a specialized diet, you may want to bring additional items.</i><strong>Please check with our staff upon arrival for refrigeration options as you may not keep food in your room.</strong></li>
<li>If you need to cancel or reschedule, please contact us at <a href="mailto:info@montserratretreat.org">info@montserratretreat.org</a></li>
<li>If you want to make payments toward your retreat: <a href="https://montserratretreat.org/retreat-offering-body">https://montserratretreat.org/retreat-offering-body</a></li>
<li>Arrival Time is between 4-6 PM on {{$order->event->start_date}}</li>
<li>For more information about our retreats and what to expect, please see our <a href="https://montserratretreat.org/retreat-frequently-asked-questions">Frequently Asked Questions</a> page.</li>
</ul>',
                'created_at' => '2023-01-25 17:34:34',
                'updated_at' => '2023-02-04 12:42:44',
                'deleted_at' => null,
            ],
            40 => [
                'id' => 41,
                'title' => 'squarespace_order_fulfillment',
                'label' => 'body',
                'locale' => 'es_ES',
                'snippet' => '{{$order->retreatant->first_name}}, <br /><br /> ¡Gracias por registrarse en {{$order->event->title}}!<br /><br /> Por favor, revise los siguientes puntos para prepararse para su retiro:<br />
<ul>
<li>Las opciones de comidas vegetarianas, sin gluten y sin lácteos están disponibles si se solicitan antes del primer día del retiro. Además, se ofrece una amplia variedad de opciones en nuestra barra de ensaladas.
<i>Si tiene alguna dieta más específica, le recomendamos que traiga alimentos adicionales.</i>
<strong>Por favor, asegúrese de consultar con nuestro personal a su llegada sobre las opciones de refrigeración disponibles, ya que no se permite guardar alimentos en las habitaciones.</strong></li>
<li>Si necesita cancelar o reprogramar, contáctenos en <a href="mailto:info@montserratretreat.org">info@montserratretreat.org</a></li>
<li>Si desea realizar pagos para su retiro: <a href="https://montserratretreat.org/retreat-offering-body">https://montserratretreat.org/retreat-offering-body</a></li>
<li>La hora de llegada es entre las 4 y las 6 p. m. el {{$order->event->start_date}}</li>
<li>Para obtener más información sobre nuestros retiros y qué esperar, consulte nuestra <a href="https://montserratretreat.org/retreat-frequently-asked-questions">página de preguntas frecuentes</a>.</li>
</ul>',
                'created_at' => '2023-01-26 20:28:33',
                'updated_at' => '2023-02-04 12:41:48',
                'deleted_at' => null,
            ],
            41 => [
                'id' => 42,
                'title' => 'squarespace_order_fulfillment',
                'label' => 'subject',
                'locale' => 'en_US',
                'snippet' => 'Montserrat Retreat Registration Confirmation and Helpful Information',
                'created_at' => '2023-02-04 09:40:04',
                'updated_at' => '2023-02-04 12:41:18',
                'deleted_at' => null,
            ],
            42 => [
                'id' => 43,
                'title' => 'squarespace_order_fulfillment',
                'label' => 'subject',
                'locale' => 'es_ES',
                'snippet' => 'Confirmación de registro e información útil para su Retiro en Montserrat',
                'created_at' => '2023-02-04 10:01:47',
                'updated_at' => '2023-02-04 18:33:17',
                'deleted_at' => null,
            ],
        ]);
    }
}
