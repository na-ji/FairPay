<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            // FOS
            new FOS\UserBundle\FOSUserBundle(),
            new FOS\RestBundle\FOSRestBundle(),

            // OAuth
            new HWI\Bundle\OAuthBundle\HWIOAuthBundle(),

            // Bootstrap
            new Braincrafted\Bundle\BootstrapBundle\BraincraftedBootstrapBundle(),

            // JMS
            new JMS\DiExtraBundle\JMSDiExtraBundle($this),
            new JMS\AopBundle\JMSAopBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),

            // KNP
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),

            // Nelmio
            new Nelmio\ApiDocBundle\NelmioApiDocBundle(),

            // Doctrine
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),

            // Ferus
            new Ferus\UserBundle\FerusUserBundle(),
            new Ferus\StudentBundle\FerusStudentBundle(),
            new Ferus\AccountBundle\FerusAccountBundle(),
            new Ferus\TransactionBundle\FerusTransactionBundle(),
            new Ferus\SellerBundle\FerusSellerBundle(),
            new Ferus\EventBundle\FerusEventBundle(),
            new Ferus\MailBundle\FerusMailBundle(),
            new Ferus\FCFSBundle\FerusFCFSBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
