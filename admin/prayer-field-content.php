<?php
if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

//wp i18n make-pot . languages/default.pot --skip-audit --subtract="languages/terms-to-exclude.pot"

class P4_Ramadan_2024_Content {

    public static function install_content( $language = 'en_US', $names = [], $from_translation = null ) {
        $campaign = DT_Campaign_Settings::get_campaign();
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
                'post_type'  => PORCH_LANDING_POST_TYPE,
                'post_status'   => 'publish',
                'post_author'   => get_current_user_id(),
                'meta_input' => [
                    PORCH_LANDING_META_KEY => $slug,
                    'post_language' => $language,
                    'day' => $i + 1,
                    'fuel_tag' => 'ramadan_2024',
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
            load_plugin_textdomain( 'ramadan-2024', false, trailingslashit( dirname( plugin_basename( __FILE__ ), 2 ) ) . 'languages' );
        }

        $data = [
            //day 1
            [
                __( 'In Islam God has 99 names–such as All-Merciful, The Beneficent, The Source of Peace–but none of those names is Love. Father God, who reveals yourself as the God of Love throughout the Bible, please reveal yourself to Muslims [in location] with your true nature.', 'ramadan-2024' ),
                __( 'God\'s love overcomes rejection. "And so we know and rely on the love God has for us. God is love. Whoever lives in love lives in God, and God in him" (1 John 4:16).

Pray for Christians from a Muslim background [in location] to overcome rejection they have experienced through the love God showed us on the cross of Christ.', 'ramadan-2024' ),
                __( 'To sustain movement, groups and leaders must cultivate bonds of brotherhood and sisterhood. We must practice the New Testament’s ‘one another’ passages. Without this grace, a disciple making movement simply will not happen. Pray for our brothers and sisters [in location] to more fully experience the "one anothers" in this passage from Romans 12:

“Don’t just pretend to love others. Really love them... Love each other with genuine affection, and take delight in honoring each other... When God’s people are in need, be ready to help them. Always be eager to practice hospitality...Be happy with those who are happy, and weep with those who weep. Live in harmony with each other.”', 'ramadan-2024' ),
                __( 'Many Christians [in location] struggle financially. Pray that as new bodies of believers form, they will come together and generously help one another with needs.', 'ramadan-2024' ),
                __( 'We are to love God with all our heart, soul, mind, and strength. As we pray for a gospel movement [in location], let us pray that the Lord would sanctify our love.

“Remain in my love. When you obey my commandments, you remain in my love, just as I obey my Father’s commandments and remain in his love. I have told you these things so that you will be filled with my joy. Yes, your joy will overflow!” (John 15:9b-11).

Pray for the grace of abiding in Christ.
Pray for the grace of obedience.
Ask that the joy of Jesus would fill believers’ hearts as they remain in His love by obeying His commandments.', 'ramadan-2024' ),
            ],
            //day 2
            [
                __( 'In Islam, it is a sin to doubt. It leaves many Muslims with fear of eternal damnation if they question anything they have been taught about religion. Pray today for Muslims [in location] to seek the true God who is big enough for our questions and doubts.', 'ramadan-2024' ),
                __( 'Our inheritance is not intimidation: it is in God. "For God did not give us a spirit of fear, but a spirit of power, of love, and of self-control" (2 Timothy 1:7).

Pray for Christ followers [in location] to renounce intimidation from the Muslim society around them and to put trust in God.', 'ramadan-2024' ),
                __( '“Jesus came and told his disciples, ‘I have been given all authority in heaven and on earth. Therefore, go and make disciples of all the nations, baptizing them in the name of the Father and the Son and the Holy Spirit. Teach these new disciples to obey all the commands I have given you. And be sure of this: I am with you always, even to the end of the age’” (Matt 28:18-20).

Believers must engage lostness on a daily basis, sharing boldly and broadly everything they’re learning from God. Ask that workers would make disciples and not just converts. Intercede for emerging church communities to start new groups. Pray for new communities of faith to quickly be baptized.', 'ramadan-2024' ),
                __( 'Pray that Christians around the country will have one unified vision of reaching their country.', 'ramadan-2024' ),
                __( 'O Father! We ask that you would build your church [in location] and continue to catalyze the spread of a disciple making movement that transforms this nation: disciples making disciples, leaders raising leaders, groups starting groups, and churches planting churches. Lord, as your people learn to love God, serve the lost, care for each other, follow through on their commitments, and strategize effectively, would your grace guide in all things and your love sustain through all seasons.

Amen', 'ramadan-2024' ),
            ],
            //day 3
            [
                __( 'Islam teaches that Muslims are born into Islam, inheriting the religion of their parents. Christianity teaches the opposite, each person must make a personal decision to follow Christ and His teachings. Today we pray into this issue and ask for God to give grace to Muslims [in location] to question this teaching that they inherited their religion from their parents.', 'ramadan-2024' ),
                __( 'We are called to live in freedom. "[Jesus said:] Then you will know the truth, and the truth will set you free" (John 8:32).

Pray for Christians from a Muslim background [in location] to root themselves in the freedom they have in Christ.', 'ramadan-2024' ),
                __( '“Yes, even today when they read Moses’ writings, their hearts are covered with a veil, and they do not understand” (2 Cor 3:15).

Lord, remove the veil. Remove the blinders that keep Muslims from seeing the truth of Christ. May the gospel liberate people from blindness. May the principalities and powers and spiritual forces of evil [in location] (Eph 6) be shut down, silenced, broken, rendered impotent. Jesus, your cross conquered the powers: the powers of death, Satan, and his kingdom. You have won the victory. And now, Lord, we call on your presence and power, your angels and ministers, to move in the spiritual realm [in location]. As Daniel prayed and angels were dispatched and fought wars in the heavenly places, we believe your angels are on the move [in location], and we expect spiritual breakthrough this month of Ramadan.', 'ramadan-2024' ),
                __( 'Pray that God would protect Christians [in location] from distractions and false teachings.', 'ramadan-2024' ),
                __( 'Lord Jesus, your words are life. May we say ‘yes’ to life-giving connection to God, which comes as we obey, as we practice, as we put into action our faith. 

Lord, allow believers [in location] to reject passive, consumerist tendencies in their faith. Instead, empower them to be a priesthood of believers, a holy nation, called for a purpose, commissioned by God to render into the world the rule and reign of Christ. Let them shine the goodness of Christ’s light into the shadow and chaos of this present darkness.', 'ramadan-2024' ),
            ],
            //day 4
            [
                __( 'Islam teaches that women cannot fast or pray when they are menstruating. We thank God that this is not a reality for us in Christ. Pray for women [in location] today who cannot fast because they are menstruating and will have to make up this day of fasting later in the year by themselves. Pray for their hearts to be softened to a God who welcomes them into His presence any day of the year because of Christ\'s blood on the cross.', 'ramadan-2024' ),
                __( 'Our bodies belong to God. "Do you not know that your body is a temple of the Holy Spirit, who is in you, whom you have received from God? You are not your own; you were bought at a price. Therefore honor God with your body" (1 Corinthians 6:19-20).

Pray for Christians from a Muslim background [in location] to live in the reality that their blood price has been paid in Christ and to honor God with their bodies.', 'ramadan-2024' ),
                __( '“And every day, in the temple and from house to house, they did not cease teaching and preaching that the Christ is Jesus” (Acts 5:41).

Ask for believers [in location] to saturate the country with the truth that Jesus is the Christ.
Ask for grace to share every day and to ceaselessly preach the truth.', 'ramadan-2024' ),
                __( 'Pray that Christians [in location] will search out unreached peoples around them which have not yet been touched by the Gospel. Pray for God to send harvesters to these other groups.', 'ramadan-2024' ),
                __( 'Father, we want to be a people that steward our calling as image-bearers of God. Therefore, help us, like you, to be keen on the regeneration of communities. Where things have fallen apart, where the center has not held, where the chaos of the day has reigned: let us think alternative to the status quo, offering novel solutions to wicked, complex problems. 

Lord, may your church [in location] bless the communities they invest in. May they incarnate and demonstrate the love of God among their friends and communities. And as believers bless the neighborhoods, meeting their felt needs, would you allow persons of peace to emerge who want to join with them and ultimately You, in your mission–on earth as it is in Heaven. Lord, may they be the laborers and the workers for the new fields where You’re working!

Amen.', 'ramadan-2024' ),
            ],
            //day 5
            [
                __( 'There are many teachings in Islam that allow for murder, enslavement, rape, and abuse of women. Today we pray for both men and women [in location] to see the value of women, who are created by God as His image bearers as well.', 'ramadan-2024' ),
                __( 'Men and women are equal before God, and one group is not superior over another: "...there is neither Jew nor Greek, slave nor free, male nor female, for you are all one in Christ Jesus" (Galatians 3:28).

Pray for Christians from a Muslim background [in location] to renounce every way they have believed lies that men and women are not equal before God.', 'ramadan-2024' ),
                __( '“What you see was predicted long ago by the prophet Joel: ‘In the last days,’ God says, ‘I will pour out my Spirit upon all people. Your sons and daughters will prophesy. Your young men will see visions, and your old men will dream dreams. In those days I will pour out my Spirit even on my servants—men and women alike—and they will prophesy. And I will cause wonders in the heavens above and signs on the earth below…before that great and glorious day of the Lord arrives. But everyone who calls on the name of the Lord will be saved’”(Acts 2:16-21).

God pour out your Spirit.
Lord, let young and old, rich and poor, male and female to be filled with your Spirit.
Give visions and dreams.
Create powerful encounters with You, the living God.', 'ramadan-2024' ),
                __( 'Pray that God would free all those following Christ – new and mature believers [of location] – of the spiritual bondage of the past.', 'ramadan-2024' ),
                __( 'Lord, you did it then, and you can do it now. You are the God of dreams and visions. Lord we pray in one voice that you would visit our Muslim brothers and sisters in the night through dreams. And we pray, too, that you would visit them during the day in open visions. We believe your heart is for movement breakthrough, so let your Kingdom come and your will be done here [in location] as in heaven.', 'ramadan-2024' ),
            ],
            //day 6
            [
                __( 'Many Muslims when faced with difficult questions about their religion fall back on the claim that God is unknowable. In Christianity, though we cannot fathom the fullness of who God is, we do believe that God revealed Himself to us in Christ and wants to be known by us. Today we pray for Muslims [in location] to encounter God by knowing Christ.', 'ramadan-2024' ),
                __( 'Let us revel in Christ\'s victory, unity in Christ\'s love, and the cross. "But thanks be to God, who always leads us in triumphal procession in Christ and through us spreads everywhere the fragrance of the knowledge of him. For we are to God the aroma of Christ among those who are being saved and those who are perishing" (2 Corinthians 2:14-15).

Pray for new Christ followers [in location] to renounce inferiority and glory in Christ\'s triumph over death through the cross.', 'ramadan-2024' ),
                __( '“There is neither Jew nor Gentile, neither slave nor free, nor is there male and female, for you are all one in Christ Jesus” (Galatians 3:28). 
Ask that in Christ there would be no division between the sects [of location].
Pray for a release of the spirit of unity over against the spirit of violence and division.
Pray for a release of the spirit of love over and against the spirits of death and destruction.', 'ramadan-2024' ),
                __( 'Pray for Christians [in location] to grow daily in the Word.', 'ramadan-2024' ),
                __( 'Father, hear our cries. We intercede on behalf of this nation, that you would move and change its trajectory. We see, Lord, how violence and division have wreaked havoc. We acknowledge that the sins of generations have destroyed the land and undermined the peace. But we also declare your steadfast love, your faithfulness and kindness. And we call out to you now and ask for your intervening love.

Step in, O God, and do miracles. Change what cannot be changed. Break what cannot be broken. Shut what cannot be shut.

And in Your mercy open what is locked. Unbind what is bound, and loose what is contained. Release peace. Spread love. And may a mighty river of reconciliation flood this land, bringing men and women and youth together in unity–baptized into the unity of Messiah–under whom all can be healed, all can be saved, all can be delivered, and by whom every wound can be mended.

Amen', 'ramadan-2024' ),
            ],
            //day 7
            [
                __( 'There are many teachings in Islam that advocate the use of the sword (killing) to advance their religion. The teachings of Jesus calls us to surrender to the sword (martyrdom) to advance His Kingdom. Pray for Muslims [in location] to wrestle with this contrast and for their hearts to be softened to Christ.', 'ramadan-2024' ),
                __( 'We have the power of the Holy Spirit to reveal truth. "Unless I go away, the Counselor will not come to you; but if I go, I will send him to you. When he comes, he will convict the world of guilt in regard to sin and righteousness and judgement..." (John 16:7-8). 

Pray for Christians from a Muslim background [in location] to trust only the Holy Spirit to reveal truth.', 'ramadan-2024' ),
                __( '“I tell you the truth, whatever you bind on earth will be bound in heaven, and whatever you loose on earth will be loosed in heaven” (Mat 18:18).

Pray that principalities and powers over [location] would be held back, broken, and thrown down as the name of Jesus is lifted high over this nation. May we declare prophetic words over [location], releasing visions, dreams, signs, and wonders in Jesus’ name. And may followers of Jesus walk in the authority bestowed on them by Christ’s life, death, resurrection, and ascension.', 'ramadan-2024' ),
                __( 'Pray that Christians [in location] will have a heart to start new churches among their friends and family.', 'ramadan-2024' ),
                __( 'May many people [in location] come to salvation and communities of believers be planted. We pray for disciples who make disciples and churches that plant churches. Lord Almighty, may generations of believers come to faith, covering the whole nation and touching all aspects of society: economic, political, social, ecological, and cultural.

“Our hope is that, as your faith continues to grow, our area of activity among you will greatly expand, so that we can preach the gospel in the regions beyond you” (2 Co 10:15-16).', 'ramadan-2024' ),
            ],
            //day 8
            [
                __( 'The primary way Islam is growing globally is through birth rate. The primary way Christianity is growing globally is through movements of the Gospel. Pray for these movements to flow through [location] and all Muslim lands.', 'ramadan-2024' ),
                __( 'We have authority in Christ to overcome shame. "Let us fix our eyes on Jesus, the author and perfecter of our faith, who for the joy set before him endured the cross, scorning its shame, and sat down at the right hand of the throne of God" (Hebrews 12:2).

Pray for Christians from a Muslim background [in location] to overcome shame from their past, family, or society by looking to Jesus, the author and perfecter of our faith.', 'ramadan-2024' ),
                __( '“Nevertheless, the time will come when I will heal the wounds [[of location]] and give it prosperity and true peace“ (Jeremiah 33:6). 

Today, we claim this promise originally spoken over Jerusalem. Lord, we declare: the time will come when You will heal the wounds [of location], You alone can heal them. And we speak in faith over [location]: Lord, You and You alone will bring true peace and prosperity.', 'ramadan-2024' ),
                __( 'Pray that life\'s difficulties will not distract believers [in location] from God\'s purpose for their lives.', 'ramadan-2024' ),
                __( 'Ask that God’s word would spread rapidly throughout [location], being honored wherever the word of God is shared. Pray that a sense of urgency would come upon believers, old and new alike, to share this gospel of the Kingdom with all. As the Samaritan woman in John 4 quickly shared with her village and introduced them to Jesus; Lord, may new people of peace spread your gospel message to new communities now, during this month, during Ramadan.', 'ramadan-2024' ),
            ],
            //day 9
            [
                __( 'There is a hadith (teaching) in Islam that says, "Be good to your mother, Paradise is under her feet." This positive teaching is often negatively used to prevent Muslims from questioning or rejecting the religion of their parents. Today, we pray for Muslims [in location] to have courage from God to honor their parents, but not blindly follow their religion and to instead pursue Truth.', 'ramadan-2024' ),
                __( 'We have the right and the responsibility to educate ourselves and our children about spiritual matters: "…do not forget the things your eyes have seen or let them slip from your heart as long as you live. Teach them to your children and to their children after them" (Deuteronomy 4:9).

Pray for Christians from a Muslim background [in location] to renounce lies that they cannot question or investigate spiritual matters.', 'ramadan-2024' ),
                __( '“Cornelius replied, ‘Four days ago I was praying in my house about this same time, three o’clock in the afternoon. Suddenly, a man in dazzling clothes was standing in front of me. He told me, ‘Cornelius, your prayer has been heard, and your gifts to the poor have been noticed by God! Now send messengers to Joppa, and summon a man named Simon Peter. He is staying in the home of Simon, a tanner who lives near the seashore.’ So I sent for you at once, and it was good of you to come. Now we are all here, waiting before God to hear the message the Lord has given you’” (Acts 10:30-33).

Ask for workers to find those who have already had dreams or visions.
Ask for apostles to access new communities.
Ask for God’s Spirit to respond to those like the Centurion who are genuinely seeking Him.', 'ramadan-2024' ),
                __( 'Pray that God will raise up Christian leaders out of each region or state [in location].', 'ramadan-2024' ),
                __( 'You are the God of dreams and visions. Lord, we pray that you would visit our Muslim brothers and sisters in the night in dreams. And we pray, too, that you would visit them during the day in open visions. Release hope. Release peace. Release revelation of Christ in the hearts of the people [of location].', 'ramadan-2024' ),
            ],
            //day 10
            [
                __( 'Islam pursues political, societal, and top-down power structures. Christianity teaches bottom-up servant leadership (Luke 22:25-27). Pray for [location] to be transformed as Christians model Christian leadership principles and reject worldly power structures.', 'ramadan-2024' ),
                __( 'We have authority in Christ to speak the truth in love, with boldness. "Now Lord consider their threats and enable your servants to speak your word with great boldness" (Acts 4:29).

Pray for those following Jesus [in location] to speak about Christ with boldness.', 'ramadan-2024' ),
                __( '“He defends the cause of the fatherless and the widow, and he loves the foreigner residing among you, giving them food and clothing...” (Deut 10:18).

Lord, we declare on behalf of the refugees from [location]: Defend their cause; you care about their plight; you respond to their cries for justice; and you reach down from heaven to act. You are the God of the refugee, a safe haven, a strong tower. And you stand with those whose backs are up against the wall.', 'ramadan-2024' ),
                __( 'Pray that the Bible will be translated into the heart language of every people [in location]. Pray for the illiterate to have access to an audio version.', 'ramadan-2024' ),
                __( 'Intercede on behalf of Christ’s followers [in location], that their testimony about Jesus would be confirmed by God’s power working through miraculous signs and wonders. 

Lord, we need your power, not just our words! We need your living power–the same power that conquered the grave and raised Christ Jesus from the dead; the same power that delivered God’s people out from the clutches of Pharaoh’s brick-laying, back-breaking empire; the same power that created all that we see and all that we don’t! 

Holy Spirit of God, when your people pray, come in power. 
When they preach the word, come in power. 
When they face opposition, come in power. 
When they feel weak, come in power.
When they stand before crowds, come in power. 
When they weep with the lonely, come in power. 
When they fast, come in power. 
When they live and love, surround them at all times by your confirming, world-changing power.', 'ramadan-2024' ),
            ],
            //day 11
            [
                __( 'The Islamic doctrine of abrogation means that some verses in the Quran can be "canceled out" by later verses. This is contrary to the unchanging nature of God in the Bible. "Because God wanted to make the unchanging nature of his purpose very clear to the heirs of what was promised, he confirmed it with an oath. God did this so that, by two unchangeable things in which it is impossible for God to lie, we who have fled to take hold of the hope offered to us may be greatly encouraged. We have this hope as an anchor for the soul, firm and secure…" (Hebrews 6:17–19) Today we pray for people [in location] to see the unchanging nature of God, that it is impossible for him to lie, and to make him the anchor for their souls.', 'ramadan-2024' ),
                __( 'We can have confidence in the Word of God. “All Scripture is God-breathed and is useful for teaching, rebuking, correcting and training in righteousness, so that the servant of God may be thoroughly equipped for every good work” (2 Timothy 3:16). 

Pray for Christians from a Muslim background [in location] to find their confidence in the truth of the Bible and all that it says about Christ.', 'ramadan-2024' ),
                __( '“This took place for two years, so that all who lived in Asia heard the word of the Lord, both Jews and Greeks” (Acts 19:10).

Ask for multiplication and spread like we see in the book of Acts: millions of people heard in two years!
Ask boldly that all areas [of location] would hear the word of the Lord.', 'ramadan-2024' ),
                __( 'Pray for every effort of ministry and service done [in location] to be motivated by God\'s love for us, and our love for God (James 1:12, 2:5, Revelation 2:4).', 'ramadan-2024' ),
                __( 'O Lord! Teach your Church to come boldly into your presence, assured of right standing in Christ. And empower these precious brothers and sisters from your storehouse of unlimited resources. Grant them all they need. And as they grow, may Christ be more at home in their hearts as they trust Him. May the roots of their faith go down deeper and deeper into the soil of God’s marvelous love, and let them become intimately acquainted with the love of Christ that surpasses just a head’s knowledge of it. 

Father! Complete them. Perfect them. Sanctify them. Do abundantly more in their hearts and minds than we could ever ask or dare to imagine, for they are your masterpiece! You have set them apart for special works [in location] that will bring You glory.', 'ramadan-2024' ),
            ],
            //day 12
            [
                __( 'Muslims believe that the Quran is the perfect and final revelation of God. Christians believe that Jesus is. "He is the radiance of the glory of God and the exact imprint of his nature..." (Hebrews 1:1-4). Pray for Muslims [in location] to read the Gospels and see the contrast between the exact representation of God\'s nature we see in Christ and what the Quran teaches.', 'ramadan-2024' ),
                __( 'We are not defenseless or weaponless, but are spiritually armed in Christ. "Finally be strong in the Lord and in his mighty power. Put on the full armor of God, so that you can take your stand against the devil\'s schemes" (Ephesians 6:10-11).

Pray for Christians from a Muslim background [in location] to put on the armor of God and recognize their battle is not against flesh and blood but against spiritual forces.', 'ramadan-2024' ),
                __( '“You have heard me teach things that have been confirmed by many reliable witnesses. Now teach these truths to other trustworthy people who will be able to pass them on to others” (2 Tim 2:2). 

Ask for the grace of multiplication: May leaders make other leaders, and groups start other groups.
Ask for trustworthy men and women to be identified and entrusted with the gospel message.
Ask for the gift of reproducibility: in evangelism, in discipleship, and in church structures.', 'ramadan-2024' ),
                __( 'Pray that the church [in location] will be super clear: 1) that God wants to save the lost (through the Gospel) 2) that God wants the lost to become like Christ (through the church).', 'ramadan-2024' ),
                __( 'Father, we pray that the peoples [of location] will learn to study the Bible, understand it, obey it, and share it quickly and boldly with others. 

Lord, will you grant this nation the grace of multiplication: disciples who make disciples, groups that start groups, and churches that plant churches. 
Ancient of Days, may your glory and fame spread throughout [location] – and the entire region – as followers of Jesus love God by obeying His commands. 
Savior, may Your followers [in location] go to their near neighbors, bringing the life-changing presence, love, and power of God with them.', 'ramadan-2024' ),
            ],
            //day 13
            [
                __( 'Muslims and Christians often use the same Arabic word for "prayer". The meanings of that word, however, could not be more different. Islamic salat "prayer" describes the memorized recitations that Muslims must speak and the motions they must go through five times a day. Christian "prayer" describes two-directional conversation with God where Christians humbly approach the throne of grace with confidence to present requests and praise, they listen to God, and are thus transformed. Today we ask for Muslims [in location] to have the opportunity to be prayed for by a Christian and for them to have a divine encounter with God through it.', 'ramadan-2024' ),
                __( 'We can consider it a joy to suffer in Christ\'s name. "Consider it pure joy, my brothers, whenever you face trials of many kinds…” (James 1:2).

Pray for those following Christ [in location] to renounce the lie that suffering for the sake of Christ is shameful.', 'ramadan-2024' ),
                __( '“The Lord says: ‘Turn to me now while there is time. Give me your hearts. Come with fasting, weeping, and mourning. Don’t tear your clothing in grief; tear your hearts instead.’ Return to the Lord your God, for He is merciful and compassionate. He is eager to relent and not punish. Who knows? He might turn and leave behind a blessing instead of a curse. Therefore, announce a solemn assembly; call the people together to fast and pray” (Joel 2, selections). 

Pray for a spirit of prayer, fasting, and repentance to fall on the believers [in location].
Pray for a seriousness and urgency among believers.
Pray that God would respond to the prayers [of location] and that he send blessings on them.', 'ramadan-2024' ),
                __( 'Pray for wisdom about if/where Christians [in location] should use money in the emerging discipling network so that the movement ends up being healthy.', 'ramadan-2024' ),
                __( 'O Father! We come to you poor in spirit, asking…imploring…begging you for intervention in this nation and at this time. We pray, Lord, that you would raise up intercessors, people willing to stand in the gap for [location]. Raise up your prayer-warriors, and mobilize the believers to pray. 

May we pray instead of staying busy. 
May we pray instead of scheduling more activities. 
May we pray instead of filling up our time. 

Lord, have mercy. Christ, have mercy. Capture our hearts again. And make [location] a nation of sacrificial, extraordinary prayer and fasting.', 'ramadan-2024' ),
            ],
            //day 14
            [
                __( 'Muslims and Christians use the same Arabic word for "fasting". And similar to what we learned yesterday about prayer, the meanings are fundamentally different. Muslim fasting is rigidly defined as no food, water, sex, or smoking from dawn to dusk. Christian fasting takes on many more forms. Muslim fasting is enforced (or broadly promoted) in Muslim countries during Ramadan. Jesus taught, "But when you fast, anoint your head and wash your face, that your fasting may not be seen by others but by your Father who is in secret...." (Matthew 6:16-18). Today we pray for Muslims [in location] to come across Jesus\' teaching about fasting in the Sermon on the Mount and be challenged to continue to investigate His teachings.', 'ramadan-2024' ),
                __( 'The cross destroys Satan\'s power and draws us to freedom in Christ. "Now the prince of this world will be driven out, but I, when I am lifted up from the earth, will draw all people to myself” (John 12:31-32).

Pray for believers, especially those from a Muslim background, [in location] to be drawn to Jesus and repent of fear that comes from the prince of this world.', 'ramadan-2024' ),
                __( '“Jesus replied, ‘This kind can be cast out only by prayer and fasting’” (Mark 9:29).

Ask the Lord for the church [in location] to rediscover the ancient practice of fasting.
Ask Him for new spiritual authority and power to be released as movement practitioners fast and pray.', 'ramadan-2024' ),
                __( 'Pray for intentional, generous, and effective sharing between near culture ministries that are pursuing and progressing toward movement.', 'ramadan-2024' ),
                __( 'Oh Jesus! Help your apprentices [in location] be more like you, living with a sense of purpose and urgency to preach the Good News in still other places. Give us the grace to share your Gospel daily. Keep us, Lord, from being bogged down by busyness and programs that you’re not asking us to steward. Liberate our time, our attention, and our energy so that we –like you – would proclaim the Good News of the Kingdom in all communities throughout [location].', 'ramadan-2024' ),
            ],
            //day 15
            [
                __( 'Zakat, one of the five pillars of Islam, requires Muslims to donate a set percentage of their wealth each year to Muslim charities. The New Testament teaches Christians to give generously from the heart as opposed to a set percentage. Pray for the people [of location] to be challenged by the contrast between a religious rule and a heart posture and to want to understand more about the "new heart" that the Bible teaches about (Ezekiel 36:26).', 'ramadan-2024' ),
                __( 'We are called to walk in the light and live in truth:
"But whoever lives by the truth comes into the light, so that it may be seen plainly that what he has done has been done through God" (John 3:21).

Pray for all Christians [in location], particularly those from a Muslim background, to live in truth and for all of their relationships to be marked by truthfulness.', 'ramadan-2024' ),
                __( '“And so I tell you, keep on asking, and you will receive what you ask for. Keep on seeking, and you will find. Keep on knocking, and the door will be opened to you” (Luke 11:9).

Ask for the grace of persevering prayer among believers [in location].
Ask the Prince of Peace for leaders of the emerging ‘streams’ of churches and groups, that would never become so busy with activity that they cease praying extravagantly.
Ask for believers in the emerging movements to have the unabashed persistence of the widow in asking, seeking, and knocking.', 'ramadan-2024' ),
                __( 'Pray for dreams that will compel people to seek their meaning. Pray for whole families, groups, and communities to have the same dream about Jesus.', 'ramadan-2024' ),
                __( '"Even the wilderness and desert will be glad in those days. The wasteland will rejoice and blossom with spring crocuses. Yes, there will be an abundance of flowers and singing and joy! The deserts will become as green as the mountains of Lebanon, as lovely as Mount Carmel or the plain of Sharon." Isaiah 35:1-3

Father, what seems impossible – deserts becoming like green mountains – is possible with you.

We pray on behalf [of location]. Let the impossible happen!
Pray now the most impossible prayer you can imagine for [location].
What is the area [of location] that seems hopelessly dead / lifeless / incurable? Is there an area or people group or political party you would like to pray for, declaring the resurrection life of Christ?', 'ramadan-2024' ),
            ],
            //day 16
            [
                __( 'Islam teaches that deception under certain circumstances is acceptable and the effects of this teaching breeds mistrust—of God and of others. But the Bible tells us "Do not lie to each other, since you have taken off your old self with its practices and have put on the new self, which is being renewed in knowledge in the image of its Creator" (Colossians 3:9-10). Pray for people [in location] to be people who pursue truth and feel conviction about deceiving others.', 'ramadan-2024' ),
                __( 'Pray for Christians from a Muslim background [in location] to trust that God is unchanging and faithful in his relationships. He always keeps his word. 

"God is not a man, that he should lie, nor a son of man, that he should change his mind. Does he speak and then not act? Does he promise and not fulfill?" (Numbers 23:19).', 'ramadan-2024' ),
                __( '“Then Moses said, “If you don’t personally go with us, don’t make us leave this place. How will anyone know that you look favorably on me—on me and on your people—if you don’t go with us? For your presence among us sets your people and me apart from all other people on the earth” (Exodus 33:15-16).

Pray that emerging streams would host His presence as they devote themselves to prayer.
Pray that God’s presence with believers [in location] would draw men and women to the true King.', 'ramadan-2024' ),
                __( 'Pray that Christians [in location] will have vision and urgency to see all parts of their country reached with the gospel.', 'ramadan-2024' ),
                __( 'Lord, help us to release control and allow your Holy Spirit to build your church. We pray, Father, for grace to raise up new generations of leaders; grace to refuse a spirit of control; grace to resist the love of ego and our ‘little kingdoms’; grace to embrace the way of Jesus. 

Lord, make Christians [in location] more like Paul, who poured out his life like a drink offering, who labored and toiled for his spiritual children. Give them the grace that was on his life to establish self-sustaining gospel communities. And Lord, as leaders of emerging movements imitate Christ, allow new facilitators and new leaders to imitate them. In this way, Lord, may your church sustain itself: disciples making disciples, leaders raising up leaders, groups starting groups, and churches planting churches.', 'ramadan-2024' ),
            ],
            //day 17
            [
                __( 'Muslims acknowledge Jesus as a prophet from God. Let their curiosity be sparked in this season for them to learn all that Jesus says about Himself. Specifically, that He is “the way, the truth, and the life” (John 14:6) so that they may acknowledge Him as Lord and Savior.', 'ramadan-2024' ),
                __( 'Satan loves to put lies into our hearts. God’s truth protects us:
"... for your love is ever before me, and I walk continually in your truth” (Psalm 26:3).

Pray for Christians from a Muslim background [in location] to repent of every form of deception and walk in God\'s truth in all relationships.', 'ramadan-2024' ),
                __( '“Let [location] praise you, O God; let all the peoples praise you!” (Psalm 67:3).

Lord, may all [location] praise you; may they praise you from every class and sect, from every religious and educational background; may they praise you in the cities and praise you in the villages, may they praise you from the seaside and praise you atop the highest peaks. You alone are worthy to receive glory and honor and praise, Great High King, rightful Ruler [of location].', 'ramadan-2024' ),
                __( 'Pray for faith, not fear, to be what controls Christians [in location].', 'ramadan-2024' ),
                __( 'With this news, strengthen those who have tired hands, and encourage those who have weak knees. Say to those with fearful hearts, “Be strong, and do not fear, for your God is coming to destroy your enemies. He is coming to save you.” Isaiah 35:3-4

Lord, to those with tired hands, have mercy. 
To those with weak knees, Lord, have mercy. 
To those with fearful hearts, Lord, have mercy. 

Pray for pastors, missionaries, and ministers, that the Lord would strengthen their tired hands.
If you know people [in location], choose a few names and speak the blessing of strength and courage over their hearts.
Declare the victory of Jesus over every spiritual enemy [in location].', 'ramadan-2024' ),
            ],
            //day 18
            [
                __( 'Muslims pray prescribed prayers five times a day. Lord, as people from [location] turn to Christ, teach them how to keep spiritual rhythms, turning it into an intimate time with you and not simply a ritual. ', 'ramadan-2024' ),
                __( 'In the gospels, Jesus says "I tell you the truth" 78 times and declares that we can only come to God through truth: "God is spirit, and his worshipers must worship in spirit and in truth" (John 4:21).

Pray for Christians from a Muslim background [in location] to grow each day in worshiping God in spirit and in truth.', 'ramadan-2024' ),
                __( '“You are the God who works wonders; you have made known your might among the people [of location]” (Psalm 77:14).

O Lord, Sovereign over [location]! We come to you today, again, to sing your praise and declare your worth. You are worthy! You alone work wonders! You are the miracle maker, the Creator God, the One by whom all things came into being and through whom all life is sustained. Lord, demonstrate your might and power [in location]. Truly, You alone are God.', 'ramadan-2024' ),
                __( 'Pray for great clarity (even generational maps that highlight key issues: https://zume.training/generational-mapping/) about areas where Christians [in location] may be distracted or deceived, making their work for the Lord just busyness and not genuinely fruitful.', 'ramadan-2024' ),
                __( 'Lord, we remember our brothers and sisters today from non-Christian backgrounds. They did not grow up learning about you and what you’re like. And so we pray, Lord, that you would recreate them, that you would transform their thoughts and feelings about God, and conform their beliefs to the reality of your Goodness.

Lord, have mercy. Christ, have mercy. Spirit, have mercy.

Amen', 'ramadan-2024' ),
            ],
            //day 19
            [
                __( 'Islam teaches an emotional worldview that Muslims are superior to non-Muslims. Lord, help believers [in location] shed the sins that so easily entangle them and instead put on their "new self" finding their value comes from You. ', 'ramadan-2024' ),
                __( 'Lord help new followers of Christ [in location] renounce attitudes that place people in positions of superiority or inferiority. Let them, instead, follow Jesus’ humble example in Philippians 2:5-11, "Your attitude should be the same as that of Christ Jesus: Who, being in very nature God, did not consider equality with God something to be grasped, but made himself nothing, taking the very nature of a servant, being made in human likeness..."', 'ramadan-2024' ),
                __( '“Jesus said to her, ‘Everyone who drinks of this water will be thirsty again, but whoever drinks of the water that I will give him will never be thirsty again. The water that I will give him will become in him a spring of water welling up to eternal life’” (John 4:13,14).

Pray for divine satisfaction in Christ to be released over all peoples [in location].
Pray that God, in His mercy, would liberate the time, attention, and energy of the people [of location] for His purposes in His Kingdom.', 'ramadan-2024' ),
                __( 'Pray for Christians to meet needs, preferably supernaturally through the Lord, and that their family members and friends would be witnesses of God\'s provision.', 'ramadan-2024' ),
                __( 'Lord, please lead [location] back to its true source of life – the fountain of living water, the light by which we see, the One true Christ. In You, O Lord, may we never thirst again.

Amen', 'ramadan-2024' ),
            ],
            //day 20
            [
                __( 'The month of Ramadan is known as ‘the month of repentance,’ and so as we pray for a gospel movement to transform this nation, let us cry out for God’s Kingdom to come, for a spirit of repentance to fall on the peoples living [in location], whether they are Sunnis, Shiite, Sufi, or Christians from a Muslim background; rich and poor, young and old, male and female.', 'ramadan-2024' ),
                __( 'Our inheritance is not timidity: it is in God. "For you did not receive a spirit that makes you a slave again to fear, but you received the Spirit of sonship. And by him we cry, ‘Abba Father’. The Spirit himself testifies with our spirit that we are God’s children, heirs of God and co-heirs with Christ, if indeed we share in his sufferings in order that we also share in his glory” (Romans 8:15-17).

Pray for Christians from a Muslim background [in location] to renounce fear and every form of slavery to it.', 'ramadan-2024' ),
                __( '“Do not be deceived: God is not mocked, for whatever one sows, that will he also reap. For the one who sows to his own flesh will from the flesh reap corruption, but the one who sows to the Spirit will from the Spirit reap eternal life” (Gal 6:7-8). 

Boldly ask that the veil of deception would be removed, that people would see the destructiveness of sin and living for the ego.
Pray for a spirit of deliverance to work mightily [in location] to enable them to sow to the Spirit.
Ask that the reward for sowing to the Spirit would be gratifying and convincing, especially for our new believing brothers and sisters.', 'ramadan-2024' ),
                __( '“Don’t you see how wonderfully kind, tolerant, and patient God is with you? Does this mean nothing to you? Can’t you see that his kindness is intended to turn you from your sin?” (Romans 2:4).

Declare the loving kindness of God, that His mercies are new every morning, that His faithfulness to [location] is indeed great.
Declare that this year is the year of the Lord’s favor, that this month is the month of repentance, that this month is when God’s Kingdom is at hand.', 'ramadan-2024' ),
                __( 'Across church planting movements globally, we see God granting a kind of grace for repentance. When believers share, people respond. There is a softness of heart, an openness to the move of the Spirit. Unlike Pharaoh, who hardened his heart and stubbornly refused to submit, people are ready to respond with soft hearts. In disciple making movements, apprentices of Jesus share with friends, with family, with their natural communities, and God’s grace for repentance is present.

Lord, soften hearts. Let those with ears to hear, let them hear. Give all those whom you are wooing the courage to repent and follow you.', 'ramadan-2024' ),
            ],
            //day 21
            [
                __( 'Islam teaches that God is unknowable and as a result many feel like God is distant. We know the truth is that God Almighty wants an intimate relationship with His followers because He is a good Father who knows the hairs on our head (Luke 12:7). Lord, let all new followers of Christ [in location] be filled with joy at knowing the intimacy of God, who calls us "beloved".', 'ramadan-2024' ),
                __( 'We are called to live in freedom. "It is for freedom Christ has set us free. Stand firm, then, and do not let yourselves be burdened again by a yoke of slavery" (Galatians 5:1).

Pray for Christians from a Muslim background [in location] to stand firm in Christ and reject the yoke of slavery to salvation through works.', 'ramadan-2024' ),
                __( 'Jer 2:11, 13

“Has any nation ever traded its gods for new ones, even though they are not gods at all? Yet my people have exchanged their glorious God for worthless idols! “For my people have done two evil things: They have abandoned me—the fountain of living water. And they have dug for themselves cracked cisterns that can hold no water at all!”

Repent on behalf [of location]. 
Pray that God would expose the worthlessness of their idols: workaholism, busyness, vanity, and addictions of all kinds (e.g. Instagram, social media, gaming, pornography, drug and alcohol abuse, etc.).
Ask that God would powerfully break cycles of escape, acting out, and addiction.
Pray for a divine return to the fountain of living water, who is Christ.', 'ramadan-2024' ),
                __( 'Often it is hard to find places for believers to meet because the rest of their families are not believers and will not allow it. Pray for places to meet and study the Bible and pray.', 'ramadan-2024' ),
                __( '“‘Come, O breath, from the four winds! Breathe into these dead bodies so they may live again.’ So I spoke the message as he commanded me, and breath came into their bodies. They all came to life and stood up on their feet—a great army” (Ezekiel 37:9b-10). 

Lord, with one phrase–‘Lazarus! Come forth!’—you raised a dead man; and with one phrase–‘Come, O breath, breathe into these dead bodies that they may live again’–you raised a dead nation; you reconstituted them into an army: the forces of Yahweh. And today, we join in accord with your Word: [location], live! Receive the breath of the Lord, the Spirit of the triune God. Be raised to life. Return and live. Be dead no longer; slumber no longer; be sick no more. Return to Life, [location], and live!', 'ramadan-2024' ),
            ],
            //day 22
            [
                __( 'In many parts of the Muslim world, Islam is passed down more through tradition, family, and society than in formal education. Prayer, fasting, and going on the Hajj are mostly done in a communal context. Today we pray in faith for our brothers and sisters [in location] to find community and family in your Church. We pray they would have vision for sharing what they are learning about Christ in their community, families, and networks. ', 'ramadan-2024' ),
                __( 'Our distinctive marks are not humiliation or inferiority, but Christ’s victory, unity in Christ’s love, and the cross. "If anyone would come after me, he must deny himself and take up his cross daily and follow me" (Luke 9:23).

Pray for Christians from a Muslim background [in location] to be freed from every need to self-promote, boast, and compensate for any sense of inferiority. May they embrace Jesus\' example of self-denial and follow Him.', 'ramadan-2024' ),
                __( '“And they sing the song of Moses, the servant of God, and the song of the Lamb, saying, ’Great and amazing are your deeds, O Lord God the Almighty! Just and true are your ways, O King [of location]!’” (Rev 15:3). 

Father, this scripture speaks truth: one day, [location] will sing the song of Moses, the song of Miriam (Exodus 15:20-21), and they shall dance before the Lord as a once-captive people now walking across a dry sea, a once-imprisoned people now liberated from the brutality of Pharaoh. The truth is that all the people [of location] shall sing: great and marvelous are your deeds, Lord God Almighty; just and true are your ways, O Lord, King of Ages!', 'ramadan-2024' ),
                __( 'Christians are often persecuted by friends and family. Sometimes they have a hard time finding people who are willing to learn and grow with them. Pray that God will guide new believers [in location] to those they already know who are searching.', 'ramadan-2024' ),
                __( 'Lord of compassion, would you rise and deliver your imprisoned people. Have mercy on those whose attention is captured by distractions and cheap thrills; have mercy on those whose time is consumed by workaholism and mindless activity; have mercy on those whose energy is sapped by the toxic effects of addiction, over-consumption, and escapism. Lord, have mercy; Christ, have mercy.', 'ramadan-2024' ),
            ],
            //day 23
            [
                __( 'Muslims (and all people, really) care deeply about their outward appearance or reputation in the community. But Jesus cares about the person\'s heart. Religion can change outward behavior but can\'t change inward attitudes—only the Spirit of God can do that. Pray for the people [of location] to be convicted about their need for a clean heart and to seek out Jesus\' teachings on the topic.', 'ramadan-2024' ),
                __( 'We have the power of the Holy Spirit to reveal the truth. "But when he, the Spirit of truth, comes, he will guide you into all truth" (John 16:13).

Pray for all Christians, new and mature, from a Muslim background [in location] to trust only the Holy Spirit to guide them into all truth and to obey whatever he says.', 'ramadan-2024' ),
                __( '“Don’t just pretend to love others. Really love them. Hate what is wrong. Hold tightly to what is good. Love each other with genuine affection, and take delight in honoring each other” (Rom 12:9-10). 

Pray for hatred of wrong in communities throughout [location]…not hatred of people, but hatred of evil.
Pray that communities would cling to and love what is good.
Ask that God’s spirit would help people honor one another and delight in one another.', 'ramadan-2024' ),
                __( 'Sometimes, as Christians, we are frozen by fear. Fear of persecution. Fear of rejection. Fear of losing something dear to us. Pray that God will give boldness and joy to Christians [in location] as they ponder what God has done in their own lives.', 'ramadan-2024' ),
                __( 'Lord of community, we pray you would unmake the toxic ways of relating to one another [in location]. So many negative patterns have been established! So many sins have been entrenched! The enemy has had his way for far too long. Do something miraculous, Lord.

We pray specifically for emerging churches, discovery groups, and new disciples. We ask you would teach them the Way of Christ–the alternative way that enables communities to flourish. Rescue them from toxic relating, and release a spirit of humility and reconciliation over all brothers and sisters in the Messiah.

Amen', 'ramadan-2024' ),
            ],
            //day 24
            [
                __( 'Islam calls Jesus the "Word of God" but strongly denies that He is God. Pray for Muslims [in location] to meditate on the thought that Jesus is the "Word of God". John 1 illustrates the beautiful reality that, "the Word was with God, and the Word was God." May Muslims [in location] be prompted to research this online and find John 1. Pray for their hearts be softened as they read. ', 'ramadan-2024' ),
                __( 'We have authority in Christ to speak the truth in love, with boldness. "If anyone acknowledges that Jesus is the Son of God, God lives in him and he in God" (1 John 4:15).

Pray for Christians from a Muslim background [in location] to speak with boldness about the insights they are gaining from the Holy Spirit about the truth of who Jesus is.', 'ramadan-2024' ),
                __( '“Love is patient and kind. Love is not jealous or boastful or proud or rude. It does not demand its own way. It is not irritable, and it keeps no record of being wronged. It does not rejoice about injustice but rejoices whenever the truth wins out. Love never gives up, never loses faith, is always hopeful, and endures through every circumstance” (1 Cor 13:4-7). 

Intercede that a spirit of love would transform communities.
Pray for the grace of transformation as communities begin to relate in Kingdom ways.
Ask for one of the descriptions of love (above) to be released over [location] and especially into new groups among emerging church streams.', 'ramadan-2024' ),
                __( 'Pray that God will help Christians [in location] to look beyond narrow limits and see the possibilities of what God can do in their country. May God give them expectancy as they wait upon Him.', 'ramadan-2024' ),
                __( 'Lord, we cry: Soften hard hearts! Open deaf ears! Restore blind eyes! Where communities have hearts of stone, Lord, bring forth hearts of flesh. Have mercy! May you release a spirit of brokenness and contrition throughout the land; lead your people to grieve over injustice and sin; lead your children to search for another way. Father of kindness, have mercy. Christ, have mercy. Lead [location] to repent of its many sins.', 'ramadan-2024' ),
            ],
            //day 25
            [
                __( 'Muslims are encouraged to think about the poor during the month of Ramadan, to sympathize with them, and to make donations. Jesus loved the poor and said, "Blessed are you who are poor, for yours is the kingdom of God" (Luke 6:20). Pray for Muslims [in location] to encounter this radical teaching and to wrestle with His command to not just donate to the poor, but to know that the kingdom of heaven belongs to the poor.', 'ramadan-2024' ),
                __( 'We are not defenseless or weaponless, but are spiritually armed in Christ. "For though we live in the world, we do not wage war as the world does. The weapons we fight with are not the weapons of the world. On the contrary, they have divine power to demolish strongholds. We demolish arguments and every pretension that sets itself up against the knowledge of God, and we take captive every thought to make it obedient to Christ" (2 Corinthians 10:3-5).

Pray for followers of Jesus in the Muslim community [of location] to take captive every thought to make it obedient to Christ and to take confidence in the spiritual weapons we have to demolish arguments against him.', 'ramadan-2024' ),
                __( '“Jesus got up from the table, took off his robe, wrapped a towel around his waist, and poured water into a basin. Then he began to wash the disciples’ feet, drying them with the towel he had around him. After washing their feet, he put on his robe again and sat down and asked, ‘Do you understand what I was doing? You call me ‘Teacher’ and ‘Lord,’ and you are right, because that’s what I am. And since I, your Lord and Teacher, have washed your feet, you ought to wash each other’s feet. I have given you an example to follow. Do as I have done to you” (John 13:4-5, 12-15).

Pray that new discovery groups and emerging churches would follow the example of Christ, washing one another’s feet.
Ask that God would show the church what it means to be servant leaders in the community.
Pray the Lord would break the need for ‘competition’ and ‘one-upmanship’ and would release, instead, a spirit of humility.
Ask God to break toxic ways of relating to one another.', 'ramadan-2024' ),
                __( 'Sometimes it\'s hard to imagine that God could use us in our weakness. Many new believers are hesitant to start groups in their homes because they are afraid they don\'t know enough. Pray that young believers [in location] will rely on God\'s Word and the Holy Spirit as they discover with their friends and family.', 'ramadan-2024' ),
                __( '“For you have heard of my former life in Judaism, how I persecuted the church of God violently and tried to destroy it. [But eventually the churches could testify:] “He who used to persecute us is now preaching the faith he once tried to destroy” (Gal 1:13 & 23).

Pray that extremists and violent zealots would encounter the King of Peace, Jesus, and would follow him in self-sacrificing love.
Pray that a spirit of peace would be released over the people [of location]. From the fields to the suburbs, from the villages to the skyscrapers, from the kitchen table to the halls of power, let Apostle Pauls be raised up and let their hearts turn towards building your Kingdom instead of trying to destroy it.', 'ramadan-2024' ),
            ],
            //day 26
            [
                __( 'Muslims deny that Jesus died on the cross and instead ascended to heaven without dying. This belief denies the act of atonement foundational to our faith as Christians. As many Christians around the world enter into a time celebrating Christ\'s death, burial, and resurrection, pray for Muslims [in location] to have the eyes of their heart opened to consider the possibility of Jesus\' death and resurrection.', 'ramadan-2024' ),
                __( 'The cross cancels every anti-Christ pact and destroys all its power. "And you, who were dead in your trespasses… God made alive together with him, having forgiven us all our trespasses, by canceling the record of debt that stood against us with its legal demands. This he set aside, nailing it to the cross. He disarmed the rulers and authorities and put them to open shame, by triumphing over them in him" (Colossians 2:13-15).

Pray for Christians from a Muslim background [in location] to cancel the power of and renounce every lie they\'ve heard that Jesus didn\'t die on the cross and to rejoice that they have been made alive with Christ through the cross.', 'ramadan-2024' ),
                __( '“This is what the Lord says: I would no more reject my people than I would change my laws that govern night and day, earth and sky…I will have mercy on them” (Jer 33:25).

God of Abraham, Isaac, and Jacob: we call on you to have mercy on [location], according to your word. And we declare: no more would you abandon this nation than you would change the laws governing night and day, earth and sky.', 'ramadan-2024' ),
                __( 'Time is a precious commodity. Some people [in location] work or study long hours. Pray that God will give them wisdom to prioritize their time to serve Him.', 'ramadan-2024' ),
                __( 'Lord of new identities, we pray for mercy. We pray for our non-Christian brothers and sisters to be filled with courage and faith, that they would take the radical step of baptism, and take it quickly. Holy Spirit let them revel in putting on their new self in Christ. We ask Holy Spirit that you come. Fill these new churches and believers with your presence. May they be baptized in groups, Lord, in order to establish to new churches, and may they never walk alone. We ask for your grace. Grace upon grace, upon grace, over our Muslim brothers and sisters.

Amen', 'ramadan-2024' ),
            ],
            //day 27
            [
                __( 'On or around the 27th night of Ramadan, Muslims celebrate the "Night of Power" as a special time that their prayers and good deeds count for more. They believe their chance of getting their prayers answered and miracles done are increased on this night. Pray for multitudes of Muslims from [location] to encounter Jesus tonight in a dream or vision.', 'ramadan-2024' ),
                __( 'Jesus is full of truth:
"We have seen his glory, the glory of the One and Only, who came from the Father, full of grace and truth" (John 1:14).

Pray for Christians from a Muslim background [in location] to model Jesus to those around them and to daily grow in being full of grace and truth.', 'ramadan-2024' ),
                __( '“All the ends of the earth shall remember and turn to the Lord, and all the families [of location] shall worship before you” (Psalm 22:27).

We declare today that the people [of location] are destined to worship you and obey you, to love you and to enjoy you, forever. Lord, we ask that all the sects, tribes, and families [of location] shall remember you and turn to you; every knee will bow, and every tongue will confess that Christ is the Lord.', 'ramadan-2024' ),
                __( 'Pray that Christians [in location] will recognize the specific spiritual gifts that God has given them and wisely use those to serve.', 'ramadan-2024' ),
                __( 'Father, hear our cries. Rend the heavens and come down. Your arm, O Mighty One, is not too short that it cannot save. Rise, O Mighty One, to show compassion. A bruised reed you never break, and a smoldering wick you never snuff out. 

O Father! [location] is bruised, and [location] is smoldering. Lord have mercy; Christ have mercy. Come and do miracles today [in location]. Raise the dead. Save the nation. Spread your fame. Transform this people. Recreate all our brothers and sisters in Christ.

Amen', 'ramadan-2024' ),
            ],
            //day 28
            [
                __( 'Last night many Muslims celebrated the "Night of Power" hoping that God would show up miraculously to change their circumstances (health, financial, relational, etc.). We continue to pray that they would encounter Jesus who already miraculously "showed up" as the Word who became flesh to change their current realities and eternity through His life, death, and resurrection. ', 'ramadan-2024' ),
                __( 'We have authority in Christ to speak the truth in love, with boldness. "Death and life are in the power of the tongue, and those who love it will eat its fruit" (Proverbs 18:21). Pray for Christians from a Muslim background [in location] to use their tongues to speak of the life found in Christ to those around them today.', 'ramadan-2024' ),
                __( '“And many [people [in location]] shall join themselves to the Lord in that day, and shall be my people. And I will dwell in your midst, and you shall know that the Lord of hosts has sent me to you” (Zechariah 2:11). 

Lord, it is your will, your deep desire, that Muslims [in location] shall join themselves to you. You long for them to become your people, and you promise to dwell in their midst. Lord, again, we ask for you to dwell [in location], among all of the peoples in it. Inhabit their homes. Fill their hearts. Overflow into their neighborhoods. Make them into your special people, a blessing for the nations around them. 

Amen', 'ramadan-2024' ),
                __( 'When Christians [in location] look to the West they see large buildings and programming. But what is the essence of the church? What is its function? Pray that Christians will look to the Word of God as they start house churches, and not be overwhelmed by extra-biblical expectations.', 'ramadan-2024' ),
                __( 'Ask that Jesus, the Lord of the Harvest, would release more workers into his fields [in location]. And pray that these workers would come from the harvest. We need more workers [in location]. Pray that workers from the same background as the harvest would be sent into the fields to sow and to reap, and ask that laughter would be granted to the sower as well as great joy for the reaper. Amen!', 'ramadan-2024' ),
            ],
            //day 29
            [
                __( 'Today many Christians celebrate Easter: the resurrection of Jesus from the grave. Muslims deny this fact. "And if Christ has not been raised, your faith is futile and you are still in your sins" (1 Corinthians 15:17). Pray for Muslims [in location] to be convicted of the reality that they are still in their sins and that only God Himself can provide a solution for that – the cross of Christ.', 'ramadan-2024' ),
                __( 'God\'s love overcomes rejection. "For God so loved the world that he gave his one and only Son, that whoever believes in him shall not perish but have eternal life" ( John 3:16).
Pray for Christians from a Muslim background [in location] to overcome fear of rejection by identifying with the great love God showed them in sending his Son to give them eternal life.', 'ramadan-2024' ),
                __( '“For from the rising of the sun to its setting my name will be great the people [of location], and in every place incense will be offered to my name, and a pure offering. For my name will be great among the people [of location], says the Lord of hosts” (Malachi 1:11).

Lord, may this passage come to pass in our lifetime. May your name be great among the people [of location], and may your name be worshiped and adored from the rising of the sun to its setting. Lord God Almighty, wherever incense is burned, wherever prayers are offered or beads are counted or rugs are laid out: in every mosque, in every church, in every gathering space for prayer – Lord, there, would your name be lifted high. Let [location] offer you a pure offering of adoration and praise. 

Amen', 'ramadan-2024' ),
                __( 'Pray that every man, woman, and child [in location] will hear the testimony of someone from his/her culture in-person.', 'ramadan-2024' ),
                __( 'Holy Father, Sovereign God, we give thanks for your mercies, please make them new every morning [in location]. Lord, we ask for your divine intervention: Would you lead movement practitioners to people of peace and then help those persons of peace establish new gospel-centered communities. Lord, you are the vine from which all life comes, mature those emerging communities into being New Testament churches with baptized believers obeying all the commands of Christ. May we see disciples who make disciples, leaders who make leaders, groups that start groups, and churches that plant churches. May your glory increase [in location] through the obedience and love of your followers. And may a gospel movement cover this nation, transforming it from the inside out, and impacting the entire Muslim world. 

Amen', 'ramadan-2024' ),
            ],
            //day 30
            [
                __( 'Thank the Lord for the love He has given you for the people [of location] as you prayed for them to encounter Christ this Ramadan. Pray for Him to complete the good work he has begun [in location]. Take time to listen to next steps God would have you take on behalf of the people [of location].', 'ramadan-2024' ),
                __( 'We should be known by unity in Christ\'s love. "May they be brought to complete unity to let the world know that you sent me and have loved them even as you have loved me" (John 17:23).
Pray for Christians from a Muslim background [in location] to experience complete unity with God and other Christians as Jesus prayed in John 17.', 'ramadan-2024' ),
                __( '“And this Gospel of the Kingdom shall be preached throughout the world, so that all peoples will hear it; and then the end will come” (Mathew 24:14). 

Lord, on this last day of Ramadan, we cry out to you again and declare the truth of your promise that this Gospel of Your Kingdom shall be preached throughout the entire Muslim world: from Morocco to Indonesia, from California to the streets of Paris. And [in location], again, we proclaim: North and South, East and West; mountain, coast, and valley; every family, village, town, region, and city [in location] shall hear the truth of the Gospel of Christ.', 'ramadan-2024' ),
                __( 'Pray for existing groups (friends, co-workers, families, etc.) to yearn to discover, obey, and share God\'s Word. When this happens with existing groups there are far fewer obstacles and complexities in figuring how and where to meet.', 'ramadan-2024' ),
                __( 'Lord, we lift our voice together one last time. Thank you for these 30 days of prayer for our brothers and sisters [in location]. Today we remember our brothers and sisters across the whole Muslim world, and we declare: The Good News that Christ, and not Caesar, reigns as Lord and Ruler of the Cosmos. Let this truth be heard in Mecca, the announcement that God’s Anointed, Jesus, rules as King. Let it be shared in Baghdad and Cairo, that Christ has thrown down death and conquered the grave of exile. From Libya and Tunisia to Somalia and Sudan, from the islands of Indonesia to the mountains of Pakistan, from India to Iran, from the Gulf countries to the Levant and to Turkey, through all the war-torn towns, cities, and villages of Afghanistan, Yemen, and Syria: let the good news of the saving grace of Jesus, our Lord, be preached… spread…and incarnated into the world by followers of Jesus. Let men and women, children, and whole families be baptized into the community of saints. and be filled with the presence and power of God’s indwelling Holy Spirit. And then the end will come. And finally, Lord, the Lamb of God shall receive the full reward of His suffering…in and for the Muslim world...to the great glory and praise of You, our God and Father. At long last, let Your children come running home. 

Amen. Amen.', 'ramadan-2024' ),
            ],
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
//            if ( file_exists( Ramadan_2024::$plugin_dir . 'images/' . $number . '.jpg' ) ) {
//                $image = '<figure class="wp-block-image p4m_prayer_image"><img src="' . plugins_url( 'images/' . $number . '.jpg', __DIR__ ) . '" alt="' . $number . '"  /></figure >';
//            }

            $content[] = [
                'excerpt' => wp_kses_post( ramadan_format_message( $d[0], $fields ) ),
                'content' => [
                    '<!-- wp:heading {"level":3} -->',
                    '<h3><strong>' . __( '30 Ways for Muslims to encounter Christ', 'ramadan-2024' ) . '</strong></h3>',
                    '<!-- /wp:heading -->',

                    '<!-- wp:paragraph -->',
                    '<p>' . wp_kses_post( ramadan_format_message( $d[0], $fields ) ) . '</p>',
                    '<!-- /wp:paragraph -->',

                    '<!-- wp:heading {"level":3} -->',
                    '<h3><strong>' . __( 'Liberty to the Captives', 'ramadan-2024' ) . '</strong></h3>',
                    '<!-- /wp:heading -->',
                    '<!-- wp:paragraph {"style":{"typography":{"fontSize":"11px"}}} -->',
                    '<p style="font-size:11px"><em>' . esc_html( ramadan_format_message( __( 'Each of us who comes to Christ must repent of and renounce every pact, promise, or identity we held before faith in Christ. Join us in praying for our brothers and sisters in Christ from a Muslim background as they repent of their former identity as Muslims. This prayer is inspired by chapter 7 and 8 of Liberty to the Captives by Mark Durie', 'ramadan-2024' ), $fields ) ) . '</em></p>',
                    '<!-- /wp:paragraph -->',

                    '<!-- wp:paragraph -->',
                    '<p>' . wp_kses_post( ramadan_format_message( $d[1], $fields ) ) . '</p>',
                    '<!-- /wp:paragraph -->',

                    '<!-- wp:heading {"level":3} -->',
                    '<h3><strong>' . __( 'Praying Scripture', 'ramadan-2024' ) . '</strong></h3>',
                    '<!-- /wp:heading -->',

                    '<!-- wp:paragraph -->',
                    '<p>' . wp_kses_post( ramadan_format_message( $d[2], $fields ) ) . '</p>',
                    '<!-- /wp:paragraph -->',

                    '<!-- wp:heading {"level":3} -->',
                    '<h3><strong>' . __( 'Praying for the Church', 'ramadan-2024' ) . '</strong></h3>',
                    '<!-- /wp:heading -->',

                    '<!-- wp:paragraph -->',
                    '<p>' . wp_kses_post( ramadan_format_message( $d[3], $fields ) ) . '</p>',
                    '<!-- /wp:paragraph -->',

                    '<!-- wp:heading {"level":3} -->',
                    '<h3><strong>' . __( 'Claiming Our Hope in Christ and His Heart for the Nations', 'ramadan-2024' ) . '</strong></h3>',
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