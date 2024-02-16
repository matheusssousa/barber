import TopHeader from "../components/TopHeader";
import MainHeader from "../components/MainHeader";
import MainHeaderAdmin from "../components/MainHeaderAdmin";
import Footer from "../components/Footer";
import PublicRoutes from "./PublicRoutes";
import PrivateRoutesUser from "./User/PrivateRoutesUser";
import PrivateRoutesAdmin from "./Admin/PrivateRoutesAdmin";

export default function StrutureRoute({ route }) {
    switch (route) {
        case 'Public':
            return (
                <>
                    {/* <TopHeader /> */}
                    {/* <MainHeader /> */}
                    <PublicRoutes />
                </>
            );
        case 'PrivateUser':
            return (
                <>
                    <MainHeader />
                    <PrivateRoutesUser />
                    <Footer />
                </>
            );
        case 'PrivateAdmin':
            return (
                <>
                    <MainHeaderAdmin />
                    <PrivateRoutesAdmin />
                    <Footer />
                </>
            );
        default:
            break;
    }
}