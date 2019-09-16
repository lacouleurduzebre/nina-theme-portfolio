<?php
/**
 * Created by PhpStorm.
 * User: nadege
 * Date: 2019-08-05
 * Time: 09:30
 */

namespace Theme\portfolio\fixtures;


use App\Entity\Bloc;
use App\Entity\GroupeBlocs;
use App\Entity\Langue;
use App\Entity\Menu;
use App\Entity\Region;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PortfolioRegionsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //Langue par défaut
        $repoLangue = $manager->getRepository(Langue::class);
        $langue = $repoLangue->findOneBy(['defaut' => 1]);

        //Menu principal
        $repoMenu = $manager->getRepository(Menu::class);
        $menu = $repoMenu->findOneBy(['defaut' => 1, 'langue' => $langue]);

        if(!$menu){
            $menu = new Menu();
            $menu->setNom('Menu principal (Portfolio)')
                ->setLangue($langue);
            $manager->persist($menu);
            $manager->flush();
        }

        //Régions
        $repoRegions = $manager->getRepository(Region::class);
        $regions = $repoRegions->findAll();
        foreach($regions as $region){
            if($region->getIdentifiant() == 'contenu'){
                $region->setPosition(1);
                $manager->persist($region);
            }else{
                $manager->remove($region);
            }
        }

        $header = new Region();
        $header->setNom('En-tête')
            ->setIdentifiant('header')
            ->setPosition(0);
        $manager->persist($header);

        $footer = new Region();
        $footer->setNom('Pied de page')
            ->setIdentifiant('footer')
            ->setPosition(2);
        $manager->persist($footer);

        //Header
        $groupeBlocHeader = new GroupeBlocs();
        $groupeBlocHeader->setNom('Header')
            ->setLangue($langue)
            ->setRegion($header)
            ->setIdentifiant('header')
            ->setPosition(0);
        $manager->persist($groupeBlocHeader);

            //Menu
        $blocMenuPrincipal = new Bloc();
        $blocMenuPrincipal->setType('Menu')
            ->setPosition(0)
            ->setGroupeBlocs($groupeBlocHeader)
            ->setContenu([
                'menu' => $menu->getId()
            ]);
        $manager->persist($blocMenuPrincipal);

            //Logo
        $blocLogo = new Bloc();
        $blocLogo->setType('LogoSite')
            ->setPosition(1)
            ->setGroupeBlocs($groupeBlocHeader)
            ->setContenu([
                'logo' => [1],
                'nom' => [0]
            ]);
        $manager->persist($blocLogo);

            //Réseaux sociaux
        $rsHeader = new Bloc();
        $rsHeader->setType('ReseauxSociaux')
            ->setGroupeBlocs($groupeBlocHeader)
            ->setPosition(2)
            ->setContenu([
                'facebook' => [1],
                'facebookUrl' => '#',
                'instagram' => [1],
                'instagramUrl' => '#',
                'twitter' => [1],
                'twitterUrl' => '#'
            ]);
        $manager->persist($rsHeader);

        //Footer
        $groupeBlocFooter = new GroupeBlocs();
        $groupeBlocFooter->setNom('Footer')
            ->setLangue($langue)
            ->setRegion($footer)
            ->setIdentifiant('footer')
            ->setPosition(0);
        $manager->persist($groupeBlocFooter);

            //Logo
        $blocLogoFooter = new Bloc();
        $blocLogoFooter->setType('LogoSite')
            ->setPosition(0)
            ->setGroupeBlocs($groupeBlocFooter)
            ->setContenu([
                'logo' => [1],
                'nom' => [0]
            ]);
        $manager->persist($blocLogoFooter);

            //Texte
        $coordonnees = new Bloc();
        $coordonnees->setType('Texte')
            ->setGroupeBlocs($groupeBlocFooter)
            ->setPosition(1)
            ->setClass('coordonnees')
            ->setContenu([
                'texte' => '<h3>Nous contacter</h3><p>Coordonnées<br>7 rue du chemin de Fer<br>67 000 STRASBOURG</p>'
            ]);
        $manager->persist($coordonnees);

            //Texte
        $nousSuivre = new Bloc();
        $nousSuivre->setType('Texte')
            ->setGroupeBlocs($groupeBlocFooter)
            ->setPosition(2)
            ->setClass('nousSuivre')
            ->setContenu([
                'texte' => '<h3>Nous suivre</h3>',
            ]);
        $manager->persist($nousSuivre);

            //Réseaux sociaux
        $rsFooter = new Bloc();
        $rsFooter->setType('ReseauxSociaux')
            ->setGroupeBlocs($groupeBlocFooter)
            ->setPosition(3)
            ->setClass('reseauxSociauxFooter')
            ->setContenu([
                'facebook' => [1],
                'facebookUrl' => '#',
                'instagram' => [1],
                'instagramUrl' => '#',
                'twitter' => [1],
                'twitterUrl' => '#'
            ]);
        $manager->persist($rsFooter);

            //Menu
        $menuFooter = new Menu();
        $menuFooter->setNom('Menu du pied de page (Portfolio)')
            ->setLangue($langue);
        $manager->persist($menuFooter);
        $manager->flush();

        $blocMenuFooter = new Bloc();
        $blocMenuFooter->setType('Menu')
            ->setPosition(4)
            ->setGroupeBlocs($groupeBlocFooter)
            ->setContenu([
                'menu' => $menuFooter->getId()
            ]);
        $manager->persist($blocMenuFooter);

        $manager->flush();
    }
}