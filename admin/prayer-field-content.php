<?php
if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

//wp i18n make-pot . languages/default.pot --skip-audit --subtract="languages/terms-to-exclude.pot"

class P4_DE_Prayer_2024_Content {

    public static function install_content( $language = 'en_US', $names = [], $from_translation = null, $campaign_id = null ) {
        $campaign = DT_Campaign_Landing_Settings::get_campaign( $campaign_id );
        if ( empty( $campaign ) ) {
            dt_write_log( 'Campaign not set' );
            return false;
        }
        $start = $campaign['start_date']['formatted'] ?? '';
        if ( empty( $start ) ) {
            dt_write_log( 'Start date not set' );
            return false;
        }

        $installed = [];
        $content = self::content( $language, $names, $from_translation ?? $language );
        foreach ( $content as $i => $day ) {

            $title = gmdate( 'F j Y', strtotime( $start . ' + ' . $i . ' day' ) );
            $date = gmdate( 'Y-m-d', strtotime( $start . ' + ' . $i . ' day' ) );
            $slug = str_replace( ' ', '-', strtolower( gmdate( 'F j Y', strtotime( $start . ' + ' . $i . ' day' ) ) ) );
            $post_content = implode( '', wp_unslash( $day['content'] ) );

//            $day = DT_Campaign_Fuel::what_day_in_campaign( $post_date );

            $args = [
                'post_title'    => $title,

                'post_content'  => $post_content,
                'post_excerpt'  => $day['excerpt'],
                'post_type'  => 'landing',
                'post_status'   => 'publish',
                'post_author'   => get_current_user_id(),
                'meta_input' => [
                    'prayer_fuel_magic_key' => $slug,
                    'post_language' => $language,
                    'day' => $i + 1,
                    'fuel_tag' => 'de_prayer_2024',
                    'linked_campaign' => $campaign['ID'],
                ]
            ];

            $installed[] = wp_insert_post( $args );

        }

        return $installed;
    }

    public static function content( $language, $names, $from_translation = 'en_US' ) {

        $fields = $names;
        add_filter( 'determine_locale', function ( $locale ) use ( $from_translation ) {
            if ( ! empty( $from_translation ) ) {
                return $from_translation;
            }
            return $locale;
        }, 1001, 1 );
        if ( $from_translation !== 'en_US' ){
            load_plugin_textdomain( 'de-prayer-2024', false, trailingslashit( dirname( plugin_basename( __FILE__ ), 2 ) ) . 'languages' );
        }

        $data = [
            [
                __( 'The internet has revolutionized the way we connect with people, share information, and do business. It has brought people from different parts of the world closer together, and it has provided opportunities for evangelism that were once impossible.', 'de-prayer-2023' ),

                __( 'Lord, we praise You for Your sovereignty over all things, including the digital world. You are the one who sustains us and gives us strength to carry out Your work. You are the source of all wisdom, and we thank You for guiding us as we plan and execute this digital evangelism campaign.
    
                “I will bless the LORD at all times; his praise will always be on my lips.
                I will boast in the LORD; the humble will hear and be glad.
                Proclaim the LORD\'s greatness with me; let us exalt his name together.”
                (Psalm 34:1-3)', 'de-prayer-2023' ),

                __( 'Lord, we pray for the people who will come across this digital engagement campaign. We ask that You open hearts to receive the message of salvation. We pray that Your Spirit would draw these people to Yourself and that they would experience Your love and grace in a powerful way.', 'de-prayer-2023' ),
            ],
            [

                __( 'Social media platforms like Facebook, Twitter, Instagram, and YouTube have millions of users who spend hours each day scrolling through their feeds. These platforms provide a unique opportunity to reach people with the gospel message. ', 'de-prayer-2023' ),

                __( 'Father, we thank You for the power of Your Word, which is living and active, and able to penetrate even the hardest hearts. We thank You for the opportunity to share it with others through this digital engagement campaign, and we pray that it would transform lives and bring many to faith in Jesus.

                “For the word of God is living and effective and sharper than any double-edged sword, penetrating as far as the separation of soul and spirit, joints and marrow.
                It is able to judge the thoughts and intentions of the heart.”
                (Hebrews 4:12)', 'de-prayer-2023' ),

                __( 'Lord, we lift up to You those who are searching for answers and spiritual guidance on social media. We pray that these digital engagement efforts will reach people and provide them with the hope and truth that they are seeking. May they encounter the love of Christ through this campaign and be transformed by His grace.', 'de-prayer-2023' ),
            ],
            [

                __( 'The COVID-19 pandemic has caused many people to turn to the internet for connection, entertainment, and information. This has created a huge mission field online, and we have an opportunity to share the hope of Christ with those who are searching for answers.', 'de-prayer-2023' ),

                __( 'Lord, we praise You for the diverse talents and gifts that You have given to Your people. We ask that You use these gifts to reach people in the digital world who may not have heard the gospel otherwise. We pray that Your Spirit would empower us to work together in unity and love for the sake of the gospel.
    
                “How delightfully good
                when brothers live together in harmony!”
                (Psalm 133:1)', 'de-prayer-2023' ),

                __( 'Father, we ask that You open doors and create opportunities for us to engage with people who are searching for truth and meaning in their lives. May we be sensitive to the leading of the Holy Spirit as we share the good news of Jesus Christ and may many come to know You as their Lord and Savior.
    
                “Devote yourselves to prayer; stay alert in it with thanksgiving.
                At the same time, pray also for us that God may open a door to us for the word,
                to speak the mystery of Christ...”
                (Colossians 4:2-3)', 'de-prayer-2023' ),
            ],
            [

                __( 'In many parts of the world, people are turning to the internet for information, entertainment, and social interaction. Digital platforms have become a crucial way for people to connect with each other, and this presents an opportunity for evangelism, discipleship, and leadership development.', 'de-prayer-2023' ),

                __( 'We praise You, Lord, for Your boundless love and mercy. You have called us to disciple people from all nations, and we are grateful for the opportunity to do so. (Ephesians 2:4-5)

                “But God, who is rich in mercy, because of his great love that he had for us,
                made us alive with Christ even though we were dead in trespasses.
                You are saved by grace!”
                (Ephesians 2:4-5)

                “Go, therefore, and make disciples of all nations,
                baptizing them in the name of the Father and of the Son and of the Holy Spirit,
                teaching them to observe everything I have commanded you.
                And remember, I am with you always, to the end of the age.”
                (Matthew 28:19-20)', 'de-prayer-2023' ),

                __( 'We pray for those who are searching for meaning and purpose online. We pray for those who are searching to deepen their relationship with Jesus. We ask that You use this digital engagement campaign to reach those individuals and draw them to Yourself.', 'de-prayer-2023' ),
            ],
            [

                __( 'Social media is one of the most popular ways people connect online. With billions of users worldwide, it provides a unique opportunity to engage a vast audience with the truths of Scripture.', 'de-prayer-2023' ),

                __( 'We exalt Your name, Lord, for Your faithfulness and steadfastness. Your promises are sure, and we trust in Your power to save.
    
                “For your faithful love is as high as the heavens; your faithfulness reaches the clouds.”
                (Psalm 57:10)', 'de-prayer-2023' ),

                __( 'Father, we pray for the technical team that will be managing the infrastructure of this digital engagement campaign. We ask that You give them wisdom and skill as they navigate the challenges of working with technology. We pray that everything will function smoothly and that there will be no technical glitches that would hinder the message from reaching its intended audience.
    
                “Whatever you do, do it from the heart,
                as something done for the Lord and not for people.”
                (Colossians 3:23)', 'de-prayer-2023' ),
            ],
            [

                __( 'Online streaming services such as YouTube, Twitch, and Facebook Live have revolutionized the way people consume media. They offer a new avenue for sharing the gospel through video content.', 'de-prayer-2023' ),

                __( 'We worship You, Lord, for Your creativity and ingenuity. You have given us the tools and resources we need to reach people with the gospel in the digital world, and we thank You for Your provision.
    
                “LORD, our Lord, how magnificent is your name throughout the earth!
                You have covered the heavens with your majesty.”
                (Psalm 8:1)', 'de-prayer-2023' ),

                __( 'Lord, we pray that Your message of salvation will reach people through every digital platform available. We ask that You guide us in using these platforms well to share Your truth and engage well with others.', 'de-prayer-2023' ),
            ],
            [

                __( "As we embark on this digital engagement campaign, please pray for the Holy Spirit's guidance, wisdom, and power to guide us in effectively engaging people through digital means.", 'de-prayer-2023' ),

                __( 'Lord, You are my rock, my fortress, and my Savior; in You, I find safety. You are my shield, the strength of my salvation, and my stronghold. I praise You for Your faithfulness and Your love, which endure forever.
                “I love you, LORD, my strength.
                The LORD is my rock, my fortress, and my deliverer,
                my God, my rock where I seek refuge,
                my shield and the horn of my salvation, my stronghold.”
                (Psalm 18:1-2)
    
                “I will praise you forever for what you have done.
                In the presence of your faithful people,
                I will put my hope in your name, for it is good.”
                (Psalm 52:9)', 'de-prayer-2023' ),

                __( 'As we embark on this digital evangelism campaign, Lord, we pray that Your Spirit would guide us in all our efforts to share the gospel message through social media. May we communicate with clarity, boldness, and grace. May our online presence reflect the love and truth of Jesus.', 'de-prayer-2023' ),
            ],
            [

                __( 'In a world that is increasingly digital, let us pray for opportunities to engage with people in deeper and more meaningful ways as we build relationships and share the love and hope found in Christ. ', 'de-prayer-2023' ),

                __( 'Father, You are the creator of all things, and everything in heaven and on earth was created by You and for You. You are before all things, and in You, all things hold together. I praise You for Your power, wisdom, and goodness.
    
                “For everything was created by him, in heaven and on earth,
                the visible and the invisible, whether thrones or dominions or rulers or authorities —
                all things have been created through him and for him.
                He is before all things, and by him all things hold together.”
                (Colossians 1:16-17)', 'de-prayer-2023' ),

                __( 'Father, we lift to You those who are feeling lonely, isolated, or disconnected in the digital world. We pray that they may find true community and belonging in the body of Christ. Help us to be a source of encouragement, support, and friendship to those who need it most.', 'de-prayer-2023' ),
            ],
            [

                __( 'As we use social media platforms to connect with people, let us pray for discernment and sensitivity to people\'s needs, fears, and doubts, and for the right words to speak into their lives.
    
                “Devote yourselves to prayer; stay alert in it with thanksgiving.
                At the same time, pray also for us that God may open a door to us for the word,
                to speak the mystery of Christ...
                Act wisely toward outsiders, making the most of the time.
                Let your speech always be gracious, seasoned with salt,
                so that you may know how you should answer each person.”
                (Colossians 4:2-6)', 'de-prayer-2023' ),

                __( 'Lord, You are the Alpha and the Omega, the beginning and the end, the first and the last. You are the one who is, who was, and who is to come, the Almighty. I praise You for Your sovereignty and Your majesty. (Revelation 1:8)', 'de-prayer-2023' ),

                __( 'Lord, we recognize that there are many barriers that prevent people from hearing the gospel message, whether it be cultural, linguistic, or technological. We ask that You break down these barriers and create opportunities for us to engage people who have never heard the good news of salvation.', 'de-prayer-2023' ),
            ],
            [

                __( 'Let us pray for those who will come across our digital content, that their hearts may be open to the gospel message and that they may be drawn to Christ. ', 'de-prayer-2023' ),

                __( 'Father, You are merciful and gracious, slow to anger, and abounding in steadfast love and faithfulness. You forgive our sins and heal our diseases. I praise You for Your compassion and Your goodness.
                “The LORD is compassionate and gracious,
                slow to anger and abounding in faithful love.”
                (Psalm 103:8)
    
                “He heals the brokenhearted and bandages their wounds.”
                (Psalm 147:3)', 'de-prayer-2023' ),

                __( 'Heavenly Father, we pray for those who are struggling with addiction, depression, anxiety, or other mental health issues. May they find hope, healing, and freedom in Jesus Christ, and may we be a source of compassion, empathy, and understanding to those who are hurting.', 'de-prayer-2023' ),
            ],
            [

                __( "As we create digital content, let us pray that it would be impactful, compelling, and relevant, and that it would resonate with people's hearts and minds.", 'de-prayer-2023' ),

                __( 'Lord, You are holy, and Your ways are just and true. You are righteous and faithful, and You keep Your promises to Your people. I praise You for Your holiness and Your righteousness.
    
                “The LORD is righteous in all his ways and faithful in all his acts.
                The LORD is near all who call out to him, all who call out to him with integrity.”
                (Psalm 145:17)
    
                “...Great and awe-inspiring are your works, Lord God, the Almighty;
                just and true are your ways, King of the nations.”
                (Revelation 15:3)', 'de-prayer-2023' ),

                __( 'Lord, we pray for the technology used in this campaign. We ask that it functions properly and that there are no technical glitches that would hinder the message from reaching its intended audience.', 'de-prayer-2023' ),
            ],
            [

                __( 'Let us pray for those who will be responding to our digital content, that they may experience the love, grace, and forgiveness of Christ and that they may be saved.
    
                “For you are saved by grace through faith,
                and this is not from yourselves; it is God\'s gift — 
                not from works, so that no one can boast.”
                (Ephesians 2:8-9)', 'de-prayer-2023' ),

                __( 'Father, You are the God of all comfort, who comforts us in all our afflictions so that we may be able to comfort those who are in any affliction with the comfort with which we ourselves are comforted by You. I praise You for Your comfort and Your compassion.
    
                “Blessed be the God and Father of our Lord Jesus Christ,
                the Father of mercies and the God of all comfort.
                He comforts us in all our affliction,
                so that we may be able to comfort those who are in any kind of affliction,
                through the comfort we ourselves receive from God.”
                (2 Corinthians 1:3-4)', 'de-prayer-2023' ),

                __( 'Lord, we pray for those who are resistant to the gospel. We ask that You soften their hearts and open their minds to the truth of Your word.', 'de-prayer-2023' ),
            ],
            [

                __( 'As we engage with people through digital means, let us pray for protection from any spiritual attacks or opposition that may come our way.', 'de-prayer-2023' ),

                __( 'Lord, You are the light of the world, and whoever follows You will not walk in darkness but will have the light of life. You have called us out of darkness into Your marvelous light. I praise You for Your guidance and Your grace.
    
                “Jesus spoke to them again: “I am the light of the world.
                Anyone who follows me will never walk in the darkness but will have the light of life.””
                (John 8:12)
    
                “But you are a chosen race, a royal priesthood,
                a holy nation, a people for his possession,
                so that you may proclaim the praises of the one who called you
                out of darkness into his marvelous light.”
                (1 Peter 2:9)', 'de-prayer-2023' ),

                __( 'Lord, we pray for the safety and protection of those involved in this campaign. We ask that You guard their hearts and minds and protect them from harm.
    
                “The LORD will protect you from all harm; he will protect your life.”
                (Psalm 121:7)', 'de-prayer-2023' ),
            ],
            [

                __( 'Let us pray for those who will be sharing our digital content with others, that they may do so with boldness and conviction, and that the gospel message would spread far and wide. ', 'de-prayer-2023' ),

                __( 'Father, You are the God of peace, who has reconciled us to Yourself through Christ and given us the ministry of reconciliation. You have made peace with us through the blood of His cross. I praise You for Your peace and Your reconciliation.
    
                “Everything is from God, who has reconciled us to himself through Christ
                and has given us the ministry of reconciliation.
                That is, in Christ, God was reconciling the world to himself,
                not counting their trespasses against them,
                and he has committed the message of reconciliation to us.”
                (2 Corinthians 5:18-19)
    
                “For God was pleased to have all his fullness dwell in him,
                and through him to reconcile everything to himself,
                whether things on earth or things in heaven,
                by making peace through his blood, shed on the cross”
                (Colossians 1:19-20)', 'de-prayer-2023' ),

                __( 'Lord, we pray for the power of Your Holy Spirit to be evident in every aspect of this campaign. We ask that You anoint our words and our efforts with Your power and Your presence.', 'de-prayer-2023' ),
            ],
            [

                __( 'As we engage with people from diverse cultures and backgrounds, may we pray for understanding, respect, and empathy. Let us ask for the ability to communicate gospel truths in ways that are relevant and meaningful.', 'de-prayer-2023' ),

                __( 'Lord, we praise You because You are the good shepherd who lays down His life for His sheep. We thank You for being the one who leads us beside still waters and restores our souls. We praise You for Your care and Your provision.
    
                “I am the good shepherd. The good shepherd lays down his life for the sheep.”
                (John 10:11)
    
                “The LORD is my shepherd; I have what I need.
                He lets me lie down in green pastures;
                He leads me beside quiet waters.
                He renews my life;
                He leads me along the right paths for his name\'s sake.”
                (Psalm 23:1-3)', 'de-prayer-2023' ),

                __( 'Lord, as we seek to communicate gospel truth through digital platforms, we ask for Your wisdom and discernment. Help us to be mindful of cultural sensitivities, norms, and taboos of different communities. May we communicate the gospel in a way that is respectful, relevant, and meaningful.', 'de-prayer-2023' ),
            ],
            [

                __( 'Let us pray for the digital platforms we use. Please ask that they be safe, secure, and free from any harmful or inappropriate content.', 'de-prayer-2023' ),

                __( 'Father, You are the God who hears our prayers and answers them according to Your will. You promise to be with us always and to never leave us nor forsake us. I praise You for Your faithfulness and Your presence.
    
                “... Be satisfied with what you have, for he himself has said,
                I will never leave you or abandon you.”
                (Hebrews 13:5)', 'de-prayer-2023' ),

                __( '
                Lord, we pray that the desires of our hearts will align with Your heart to save humanity. We ask that You guide us as we use various digital platforms to share gospel truths. Help us to remember You are with us always and will direct us if we seek You. May we seek not our own glory or fame, but that the name of Jesus be glorified in all we do.', 'de-prayer-2023' ),
            ],
            [

                __( 'As we create digital content, let us pray for creativity, inspiration, and innovation. Pray for the ability to communicate gospel truths in new and engaging ways.', 'de-prayer-2023' ),

                __( 'Jesus, we praise You for being the way, the truth, and the life. We thank You that You\'ve given a way for us to reach You, Jesus Christ, our mediator. We praise You for sending us the Holy Spirit to guide us into all truth. Thank You for Your truth and Your revelation.
    
                “Jesus told him, ‘I am the way, the truth, and the life.
                No one comes to the Father except through me.\'”
                (John 14:6)
    
                “When the Spirit of truth comes, he will guide you into all the truth.
                For he will not speak on his own, but he will speak whatever he hears.
                He will also declare to you what is to come.”
                (John 16:13)', 'de-prayer-2023' ),

                __( 'Heavenly Father, as we use digital tools to disciple and train believers, we ask that You anoint our efforts with Your Spirit. May we be faithful and effective in making disciples of all nations, may Your kingdom come, and Your will be done in the digital world as it is in heaven.', 'de-prayer-2023' ),
            ],
            [

                __( "Let us pray for those who will be supporting this digital engagement campaign. Pray that they will be filled with the Holy Spirit's wisdom and strength, and that they may experience the joy of seeing lives transformed by the gospel.", 'de-prayer-2023' ),

                __( 'Oh Lord, I praise You for being my God, deliverer, fortress, and rock of refuge. I take refuge in You, my shield, my stronghold, and my salvation. Thank You, Lord, that in You I have found my place of safety.
    
                “I love you, LORD, my strength.
                The LORD is my rock,
                my fortress, and my deliverer,
                my God, my rock where I seek refuge,
                my shield and the horn of my salvation, my stronghold...
                God — his way is perfect; the word of the LORD is pure.
                He is a shield to all who take refuge in him...
                The LORD lives — blessed be my rock!
                The God of my salvation is exalted.”
                (Psalm 18:1-2, 30, 46)', 'de-prayer-2023' ),

                __( 'Lord, we pray for the volunteers who will be supporting this digital engagement campaign. We ask that You bless them for their willingness to serve and that they will be filled with joy and a sense of purpose as they contribute to this mission. We pray that their efforts would make a real difference in the lives of those who hear the message.
    
                “Let us not get tired of doing good,
                for we will reap at the proper time if we don\'t give up.”
                (Galatians 6:9)', 'de-prayer-2023' ),
            ],
            [

                __( "As we engage with people through digital means, let us pray for patience, kindness, and gentleness. We are asking for the ability to listen and respond to people's questions and concerns in a compassionate and loving way.", 'de-prayer-2023' ),

                __( 'We praise You, Lord, because You are great and worthy of praise. You are unfathomable, O God! We thank You for being good to all and that You have compassion towards all that You have created. We praise You because You have given us life and breath!
    
                “I exalt you, my God the King, and bless your name forever and ever.
                I will bless you every day; I will praise your name forever and ever.
                The LORD is great and is highly praised; his greatness is unsearchable...
                The LORD is gracious and compassionate, slow to anger and great in faithful love.
                The LORD is good to everyone; his compassion rests on all he has made.”
                (Psalm 145:1-3, 8-9)
    
                “Let everything that breathes praise the LORD. Hallelujah!”
                (Psalm 150:6)', 'de-prayer-2023' ),

                __( 'Father, we pray for the people who will be sharing gospel truth through this digital engagement campaign. We ask that You give them boldness and wisdom as they communicate Your truth. We pray that their words would be anointed with Your power and that they would be sensitive to the leading of Your Spirit.', 'de-prayer-2023' ),
            ],
            [

                __( 'Let us pray for those who will be partnering with us in this digital evangelism campaign, that they may share our vision and passion for seeing people come to Christ, and that they may be encouraged and strengthened in their own faith.', 'de-prayer-2023' ),

                __( 'We praise You for being a great God who is above all. We praise You for being worthy of praise, glory, and honor. We thank You for allowing us to enter Your presence. We sing to You and praise You for being our rock and salvation.
    
                “Come, let\'s shout joyfully to the LORD,
                shout triumphantly to the rock of our salvation!
                Let\'s enter his presence with thanksgiving;
                let\'s shout triumphantly to him in song.
                For the LORD is a great God,
                a great King above all gods.”
                 (Psalm 95:1-3)', 'de-prayer-2023' ),

                __( 'We pray for the mental and emotional health of those involved in this campaign. We ask that You give them peace and comfort amid the stresses and challenges they face.
    
                “Don\'t worry about anything, but in everything, through prayer and petition
                with thanksgiving, present your requests to God.
                And the peace of God, which surpasses all understanding,
                will guard your hearts and minds in Christ Jesus.”
                 (Philippians 4:6-7)', 'de-prayer-2023' ),
            ],
            [

                __( "As we use digital means to share the gospel message, let us pray for the Holy Spirit's power to convict people of their sin and draw them to repentance and faith in Christ.", 'de-prayer-2023' ),

                __( 'We praise You that You search us and know us. I am in awe of Your omniscience—knowing when I sit, when I rise, and all of my thoughts. I can hide nothing from You. I cannot go anywhere where You are not with me. I praise You for knowing me intimately.
    
                “LORD, you have searched me and known me.
                You know when I sit down and when I stand up;
                you understand my thoughts from far away...
                Before a word is on my tongue, you know all about it, LORD...
                Where can I go to escape your Spirit?
                Where can I flee from your presence?
                If I go up to heaven, you are there;
                If I make my bed in Sheol, you are there...
                Search me, God, and know my heart;
                test me and know my concerns.
                See if there is any offensive way in me;
                lead me in the everlasting way.”
                (Psalm 139:1-2, 4, 7-8, 23-24)', 'de-prayer-2023' ),

                __( 'Heavenly Father, we ask that You bless our digital engagement efforts with fruitfulness and impact. May many come to know You as their Lord and Savior through our online ministry, and may Your name be glorified in all that we do.', 'de-prayer-2023' ),
            ],
            [

                __( 'Let us pray for those who are skeptical or resistant to the gospel message. We know the Lord can change even the hardest hearts. We ask that those who have hearts of stone will be softened and that they may come to know the truth and love of Christ.', 'de-prayer-2023' ),

                __( 'We praise You Lord for You are great and feared above all gods. Because of Your greatness, we can exalt You, sing to You, and proclaim Your salvation among the nations.
    
                “Sing a new song to the LORD; let the whole earth sing to the LORD.
                Sing to the LORD, bless his name; proclaim his salvation from day to day.
                Declare his glory among the nations, his wondrous works among all peoples.
                For the LORD is great and is highly praised; he is feared above all gods.”
                (Psalm 96:1-4)', 'de-prayer-2023' ),

                __( 'Lord, we pray for those who are skeptical, hostile, or indifferent to the gospel message. May Your Spirit soften their hearts and open their minds to receive the truth of Your word. Give us boldness, courage, and wisdom as we share the message of salvation with those who need it most.', 'de-prayer-2023' ),
            ],
            [

                __( 'As we create digital content, let us pray for the ability to communicate the gospel message in a way that is clear, concise, and easy to understand.', 'de-prayer-2023' ),

                __( 'I praise You because You have given me life! I thank You that we can trust You rather than man. I praise You for being the Maker of all things and are forever faithful. We praise You that You can open the eyes of the blind. Thank You for reigning over all generations.
    
                “Hallelujah!
                My soul, praise the LORD.
                I will praise the LORD all my life;
                I will sing to my God as long as I live.
                Do not trust in nobles, in a son of man, who cannot save...
                Happy is the one whose help is the God of Jacob,
                whose hope is in the LORD his God,
                the Maker of heaven and earth,
                the sea and everything in them.
                He remains faithful forever, ...
                The LORD opens the eyes of the blind.
                The LORD raises up those who are oppressed.
                The LORD loves the righteous...
                The LORD reigns forever;
                Zion, your God reigns for all generations.
                Hallelujah”
                (Psalm 146: 1-3, 5-6, 8, 10)', 'de-prayer-2023' ),

                __( 'Lord, we pray for the creative team behind this digital engagement campaign. We ask that You inspire them with fresh ideas and that they would have the resources they need to create content that is compelling and relevant. We pray that their efforts will be fruitful and that many will come to faith through their work.
    
                “Commit your activities to the LORD, and your plans will be established.”
                (Proverbs 16:3)', 'de-prayer-2023' ),
            ],
            [

                __( "Let us pray for those who will be leading and coordinating this digital engagement campaign, that they may be filled with the Holy Spirit's wisdom and discernment, and that they may be effective in their roles. Let us ask that they would rest in God alone rather than their own skills and talents.", 'de-prayer-2023' ),

                __( 'I praise You God for being my rock, stronghold, and salvation. I exalt in You because I know I can rest in You because You are the one who provides me with hope, rest, and peace. Thank You, God, that I can trust in You always and pour out my heart before You. I praise You for being my refuge!
    
                “Rest in God alone, my soul,
                for my hope comes from him.
                He alone is my rock and my salvation,
                my stronghold; I will not be shaken.
                My salvation and glory depend on God, my strong rock.
                My refuge is in God.
                Trust in him at all times, you people;
                pour out your hearts before him.
                God is our refuge.”
                (Psalm 62:5-8)', 'de-prayer-2023' ),

                __( 'We pray for the leaders and organizers of this digital evangelism campaign. We ask that You grant them wisdom, discernment, and direction as they plan and execute the campaign.
    
                “Now if any of you lacks wisdom, he should ask God
                — who gives to all generously and ungrudgingly — 
                and it will be given to him.”
                (James 1:5)', 'de-prayer-2023' ),
            ],
            [

                __( 'Social media has become a primary source of news and information for many people. Pray that our online engagement efforts will reach those who are seeking answers and spiritual guidance.', 'de-prayer-2023' ),

                __( 'I thank You, Lord, that I can boast about You! You are holy, just, trustworthy, and steadfast. You do miraculous works that cause people to turn to You. I rejoice and boast in You, for You are worthy of all praise.
    
                “I will thank the LORD with all my heart;
                I will declare all your wondrous works.
                I will rejoice and boast about you;
                I will sing about your name, Most High.”
                 (Psalm 9:1-2)', 'de-prayer-2023' ),

                __( 'Lord, we pray that as people browse the internet and social media they would find the good news of the gospel and see that it is the answer to their greatest needs.', 'de-prayer-2023' ),
            ],
            [

                __( 'The internet has made it easier than ever for people to access pornography and other harmful content. Pray that individuals who struggle with addiction to these things will find freedom and healing through the power of Christ.', 'de-prayer-2023' ),

                __( 'God, we praise You for being a God who loves integrity. We thank You for Your loving kindness that leads to repentance. We praise You for Your faithfulness and justice. We praise You for guiding us when we call out to You. May we love integrity and flee transgressions!
    
                “I will sing of faithful love and justice;
                I will sing praise to you, LORD.
                I will pay attention to the way of integrity.
                When will you come to me?
                I will live with a heart of integrity in my house.
                I will not let anything worthless guide me.
                I hate the practice of transgression;
                it will not cling to me.
                A devious heart will be far from me;
                I will not be involved with evil.”
                (Psalm 101:1-4)', 'de-prayer-2023' ),

                __( 'Father, we pray for those who struggle with addiction to harmful online content. We ask that You break the chains of addiction and bring healing and restoration to their lives. May they find freedom in Christ and be empowered to overcome the temptations that lead them down destructive paths.', 'de-prayer-2023' ),
            ],
            [

                __( 'Many people are hesitant to engage with online gospel engagement efforts due to fear of judgment or ridicule. Pray that we would be sensitive to these concerns and that our messages would be received with openness and understanding.', 'de-prayer-2023' ),

                __( 'I will praise You, O Lord, for there is no one like You! I praise You because all the nations of the earth will one day honor You. I am in awe of Your wonders and majesty. I praise You because You teach me and guide me by Your truth. I will praise You because You have delivered me from the grave. I praise You for Your faithful love!
    
                “Lord, there is no one like you among the gods,
                and there are no works like yours.
                All the nations you have made
                will come and bow down before you, Lord,
                and will honor your name.
                For you are great and perform wonders;
                you alone are God.
                Teach me your way, LORD,
                and I will live by your truth.
                Give me an undivided mind to fear your name.
                I will praise you with all my heart, Lord my God,
                and will honor your name forever.
                For your faithful love for me is great,
                and you rescue my life from the depths of Sheol.”
                (Psalm 86:8-13)', 'de-prayer-2023' ),

                __( 'God, we ask for sensitivity and discernment as we engage with unbelievers online. We pray that gospel truths will be received with openness and understanding. We ask that fear of judgment or ridicule would be overcome by Your love. May those who encounter this content be drawn to You and the hope that You offer.', 'de-prayer-2023' ),
            ],
            [

                __( 'The fast pace of the digital age can leave people feeling overwhelmed and burnt out. Pray that our engagement efforts would offer hope and rest to those who are weary.', 'de-prayer-2023' ),

                __( 'May we, like the Psalmist, always bless the Lord, praising Him continually! You are worthy Lord of all boasting, praise, honor and glory for You are great! May we praise and boast of You because of Your majesty and all that You have done for us.
    
                “I will bless the LORD at all times; his praise will always be on my lips.
                I will boast in the LORD; the humble will hear and be glad.
                Proclaim the LORD\'s greatness with me; let us exalt his name together.
                I sought the LORD, and he answered me and rescued me from all my fears.”
                (Psalm 34:1-4)', 'de-prayer-2023' ),

                __( 'Lord, we recognize the weariness and burnout that many people feel in the fast-paced digital age. We pray that our digital engagement efforts would offer them the rest and hope that they need. May they find true rest in You, and may their lives be transformed by the power of Your love and grace.
    
                “Come to me, all of you who are weary and burdened, and I will give you rest.
                Take my yoke upon you and learn from me, because I am lowly and humble in heart,
                and you will find rest for your souls. For my yoke is easy and my burden is light.”
                (Matthew 11:28-30)', 'de-prayer-2023' ),
            ],
            [

                __( 'The online world can be a breeding ground for conspiracy theories and misinformation. Pray that those who are searching for truth would find it in the message of the gospel.', 'de-prayer-2023' ),

                __( 'May we use the Psalm below to praise the Lord for the many things He has done that are worthy of praise. We thank You Lord for Your name alone is exalted and Your majesty covers the heavens and the earth!
    
                “Hallelujah!
                Praise the LORD from the heavens;
                praise him in the heights.
                Praise him, all his angels;
                praise him, all his heavenly armies.
                Praise him, sun and moon;
                praise him, all you shining stars.
                Praise him, highest heavens,
                and you waters above the heavens.
                Let them praise the name of the LORD,
                for he commanded, and they were created.
                He set them in position forever and ever;
                he gave an order that will never pass away...
                Let them praise the name of the LORD,
                for his name alone is exalted.
                His majesty covers heaven and earth.”
                (Psalm 148:1-6, 13)
                ', 'de-prayer-2023' ),

                __( 'Father, we lift up those who are searching for truth amidst the sea of misinformation on the internet. We ask that Your light would shine in the darkness and that they would be drawn to the message of the gospel. May they find true hope and purpose in You, and may their lives be transformed by Your grace.
    
                “That light shines in the darkness,
                and yet the darkness did not overcome it.”
                (John 1:5)
                 ', 'de-prayer-2023' ),
            ],
            [

                __( 'The anonymity of the internet can lead to a lack of accountability and moral responsibility. Pray that those who engage with our online efforts would be inspired to live lives that reflect the character of Christ, even when no one is watching.', 'de-prayer-2023' ),

                __( 'We praise You Lord for bringing us from death to life through Jesus Christ! We thank You for our eternal inheritance. We praise You that You refine us and are able to keep us from stumbling so that Your name receives more honor.
    
                “Blessed be the God and Father of our Lord Jesus Christ.
                Because of his great mercy he has given us new birth
                into a living hope through the resurrection of Jesus Christ from the dead
                and into an inheritance that is imperishable, undefiled, and unfading, kept in heaven for you.
                You are being guarded by God\'s power through faith for a salvation
                that is ready to be revealed in the last time.
                You rejoice in this, even though now for a short time,
                if necessary, you suffer grief in various trials so that the proven character of your faith  
                — more valuable than gold which, though perishable, is refined by fire  —
                may result in praise, glory, and honor at the revelation of Jesus Christ.”
                (1 Peter 1:3-7)', 'de-prayer-2023' ),

                __( 'God, we recognize the temptation to hide behind anonymity and avoid accountability in the online world. We pray that those who engage with our online evangelism efforts would be inspired to live lives that reflect Your character and love, even when no one is watching. May they be transformed by Your grace and empowered to make a positive impact in the world around them.', 'de-prayer-2023' ),
                ]
            ];


        function bullet_list_to_html( $message ){
            //https://stackoverflow.com/questions/2344563/a-regex-that-converts-text-lists-to-html-in-php
            $message = preg_replace( '/^-+(.*)?/im', '<ul><li>$1</li></ul>', $message );
            return preg_replace( '/(<\/ul>\n(.*)<ul>*)+/', '', $message );
        }

        function ramadan_format_message( $message, $fields ) {
            $message = make_clickable( $message );
            $message = str_replace( '[in location]', !empty( $fields['in_location'] ) ? $fields['in_location'] : '[in location]', $message );
            $message = str_replace( '[of location]', !empty( $fields['of_location'] ) ? $fields['of_location'] : '[of location]', $message );
            $message = str_replace( '[location]', !empty( $fields['location'] ) ? $fields['location'] : '[location]', $message );
            $message = str_replace( '[people_group]', !empty( $fields['ppl_group'] ) ? $fields['ppl_group'] : '[people_group]', $message );
            $message = bullet_list_to_html( $message );
            return nl2br( $message );
        }

        $content = [];
        foreach ( $data as $index => $d ){

            $number = $index +1;
            if ( $number < 10 ){
                $number = '0' . $number;
            }

//            $image = '';
//            if ( file_exists( DE_Prayer_2024::$plugin_dir . 'images/' . $number . '.jpg' ) ) {
//                $image = '<figure class="wp-block-image p4m_prayer_image"><img src="' . plugins_url( 'images/' . $number . '.jpg', __DIR__ ) . '" alt="' . $number . '"  /></figure >';
//            }

            $content[] = [
                'excerpt' => wp_kses_post( ramadan_format_message( $d[0], $fields ) ),
                'content' => [
                    '<!-- wp:heading {"level":3} -->',
                    '<h3><strong>' . __( '30 Ways for Muslims to encounter Christ', 'de-prayer-2024' ) . '</strong></h3>',
                    '<!-- /wp:heading -->',

                    '<!-- wp:paragraph -->',
                    '<p>' . wp_kses_post( ramadan_format_message( $d[0], $fields ) ) . '</p>',
                    '<!-- /wp:paragraph -->',

                    '<!-- wp:heading {"level":3} -->',
                    '<h3><strong>' . __( 'Liberty to the Captives', 'de-prayer-2024' ) . '</strong></h3>',
                    '<!-- /wp:heading -->',
                    '<!-- wp:paragraph {"style":{"typography":{"fontSize":"11px"}}} -->',
                    '<p style="font-size:11px"><em>' . esc_html( ramadan_format_message( __( 'Each of us who comes to Christ must repent of and renounce every pact, promise, or identity we held before faith in Christ. Join us in praying for our brothers and sisters in Christ from a Muslim background as they repent of their former identity as Muslims. This prayer is inspired by chapter 7 and 8 of Liberty to the Captives by Mark Durie', 'de-prayer-2024' ), $fields ) ) . '</em></p>',
                    '<!-- /wp:paragraph -->',

                    '<!-- wp:paragraph -->',
                    '<p>' . wp_kses_post( ramadan_format_message( $d[1], $fields ) ) . '</p>',
                    '<!-- /wp:paragraph -->',

                    '<!-- wp:heading {"level":3} -->',
                    '<h3><strong>' . __( 'Praying Scripture', 'de-prayer-2024' ) . '</strong></h3>',
                    '<!-- /wp:heading -->',

                    '<!-- wp:paragraph -->',
                    '<p>' . wp_kses_post( ramadan_format_message( $d[2], $fields ) ) . '</p>',
                    '<!-- /wp:paragraph -->',

                    '<!-- wp:heading {"level":3} -->',
                    '<h3><strong>' . __( 'Praying for the Church', 'de-prayer-2024' ) . '</strong></h3>',
                    '<!-- /wp:heading -->',

                    '<!-- wp:paragraph -->',
                    '<p>' . wp_kses_post( ramadan_format_message( $d[3], $fields ) ) . '</p>',
                    '<!-- /wp:paragraph -->',

                    '<!-- wp:heading {"level":3} -->',
                    '<h3><strong>' . __( 'Claiming Our Hope in Christ and His Heart for the Nations', 'de-prayer-2024' ) . '</strong></h3>',
                    '<!-- /wp:heading -->',

                    '<!-- wp:paragraph -->',
                    '<p>' . wp_kses_post( ramadan_format_message( $d[4], $fields ) ) . '</p>',
                    '<!-- /wp:paragraph -->',
                ]
            ];
        }
        return $content;
    }
}