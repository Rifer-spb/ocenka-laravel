import { TPaginated } from '@/types/types';
import { TNotary } from './types';
import Layout from '../../Layout';
import Notaries from './Notaries';

type TProps = {
    notaries: TPaginated<TNotary>;
};

export default function ({ notaries } : TProps) {
    return (
        <Layout>
            <Notaries notaries={notaries}/>
        </Layout>
    );
}
